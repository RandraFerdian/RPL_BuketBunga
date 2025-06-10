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
        // Ambil kata kunci dari input form dengan nama 'query'
        $query = $request->input('query');

        // Cari produk di mana nama_produk mengandung kata kunci
        $products = Produk::where('nama_produk', 'LIKE', "%{$query}%")
                        ->orWhere('kategori', 'LIKE', "%{$query}%")
                        ->paginate(12);

        // Tampilkan hasilnya menggunakan view yang sama dengan katalog
        return view('katalog', [
            'products' => $products,
            'query' => $query // Kirim kata kunci untuk ditampilkan di view
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