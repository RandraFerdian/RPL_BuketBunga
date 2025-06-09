<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;     // <-- TAMBAHKAN INI
use App\Models\Transaksi;  // <-- TAMBAHKAN INI
use App\Models\User;       // <-- TAMBAHKAN INI

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil data-data statistik
        $totalProduk = Produk::count();
        $totalPesanan = Transaksi::count();
        $totalPendapatan = Transaksi::where('status_pembayaran', 'lunas')->sum('total_harga');
        $totalPelanggan = User::where('role', 'pelanggan')->count();

        // Ambil 5 pesanan terakhir
        $pesananTerbaru = Transaksi::with('user')->latest()->take(5)->get();

        // Kirim semua data ke view 'admin.dashboard'
        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPendapatan',
            'totalPelanggan',
            'pesananTerbaru'
        ));
    }
}