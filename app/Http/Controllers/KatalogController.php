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
        // Ambil semua produk dan langsung kelompokkan berdasarkan kolom 'kategori'.
        $groupedProducts = \App\Models\Produk::latest()->get()->groupBy('kategori');
    
        // Kirim data yang sudah dikelompokkan ke view.
        return view('katalog', compact('groupedProducts'));
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
        // Langkah 1: Validasi input dari pengguna
        $request->validate([
            'query' => 'required|string|max:100',
        ]);

        // Langkah 2: Ambil kata kunci pencarian dari input bernama 'query'
        $query = $request->input('query');

        // Langkah 3: Cari produk di database berdasarkan nama atau kategori
        // Menggunakan paginate() agar halaman tidak berat jika hasil banyak
        $products = Produk::where('nama_produk', 'LIKE', "%{$query}%")
                            ->orWhere('kategori', 'LIKE', "%{$query}%")
                            ->latest()
                            ->paginate(12);

        // Langkah 4: Kembalikan ke view 'katalog' dengan membawa hasil produk
        // dan kata kunci pencarian untuk ditampilkan di judul.
        return view('katalog', compact('products', 'query'));
    }
    public function welcome()
    {
        // Ambil 4 produk secara acak yang memiliki gambar untuk ditampilkan
        $produks = Produk::whereNotNull('gambar')->inRandomOrder()->take(4)->get();

        // Kirim data produk ke view 'welcome'
        return view('welcome', compact('produks'));
    }
}