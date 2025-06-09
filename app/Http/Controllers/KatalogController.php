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
}