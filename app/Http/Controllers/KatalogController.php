<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Import model Produk
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Menampilkan halaman utama katalog produk.
     */
    public function index()
    {
        // 1. Mengambil semua data dari tabel 'produk' menggunakan Model
        $products = Produk::all();

        // 2. Mengirim data tersebut ke sebuah view bernama 'katalog'
        return view('katalog', ['products' => $products]);
    }
}