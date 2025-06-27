<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Menampilkan halaman utama katalog produk.
     */
    public function index()
    {
        // Mengambil semua produk dan mengelompokkannya berdasarkan kategori
        $groupedProducts = Produk::with('stok')->latest()->get()->groupBy('kategori');

        // Mengambil semua nama kategori yang unik untuk tombol filter
        $categories = Produk::select('kategori')->distinct()->orderBy('kategori', 'asc')->get();

        return view('katalog', compact('groupedProducts', 'categories'));
    }

    /**
     * Menampilkan halaman detail satu produk.*/
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        // Langsung kirim ke view tanpa dihentikan
        return view('katalog-detail', compact('produk'));
    }

    public function search(Request $request)
    {
        // Validasi input, pastikan ada query pencarian
        $request->validate([
            'query' => 'required|string|max:100',
        ]);

        $query = $request->input('query');

        // Tetap ambil semua kategori agar tombol filter bisa ditampilkan
        $categories = Produk::select('kategori')->distinct()->orderBy('kategori', 'asc')->get();

        // Query pencarian yang lebih canggih dan luas
        $produks = Produk::with('stok')
            ->where(function ($q) use ($query) {
                $q->where('nama_produk', 'like', "%{$query}%")
                    ->orWhere('kategori', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%"); // <-- Mencari di deskripsi
            })
            ->latest()
            ->paginate(12);

        // Menambahkan query ke link pagination agar filter tetap aktif
        $produks->appends(['query' => $query]);

        // Mengirim semua data yang dibutuhkan ke view
        return view('katalog', compact('produks', 'categories', 'query'));
    }

    public function showByCategory($kategori)
    {
        // Ambil semua kategori unik untuk ditampilkan kembali di navigasi kategori
        $categories = Produk::select('kategori')->distinct()->get();

        // Ambil produk yang sesuai dengan kategori yang diklik, gunakan pagination
        $produks = Produk::where('kategori', $kategori)->latest()->paginate(12);

        // Kirim data ke view yang sama dengan katalog utama, yaitu 'katalog'
        // Ini adalah praktik yang baik karena kita tidak perlu membuat file view baru
        return view('katalog', [
            'produks' => $produks,
            'categories' => $categories,
            'selectedCategory' => $kategori // Kirim nama kategori yang aktif untuk styling
        ]);
    }

    public function welcome()
    {
        // Ambil 4 produk secara acak yang memiliki gambar untuk ditampilkan
        $produks = Produk::whereNotNull('gambar')->inRandomOrder()->take(4)->get();

        // Kirim data produk ke view 'welcome'
        return view('welcome', compact('produks'));
    }
}
