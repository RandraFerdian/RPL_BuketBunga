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
        $products = Produk::latest()->paginate(12);
        return view('katalog', ['products' => $products]);
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
}