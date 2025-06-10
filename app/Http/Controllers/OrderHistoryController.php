<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Illuminate\View\View;

class OrderHistoryController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan untuk pengguna yang sedang login.
     */
    public function index(): View
    {
        // Ambil semua transaksi milik user yang sedang login, urutkan dari yang terbaru
        // dan muat relasi 'detailTransaksi' untuk efisiensi
        $orders = Auth::user()->transaksi()->with('detailTransaksi')->latest()->paginate(10);

        return view('riwayat-pesanan.index', compact('orders'));
    }

    /**
     * Menampilkan halaman detail satu pesanan.
     */
    public function show(Transaksi $transaksi) : View
    {
        // Pengecekan keamanan: pastikan pengguna hanya bisa melihat pesanannya sendiri.
        if ($transaksi->id_user !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Muat relasi detail transaksi beserta info produknya untuk ditampilkan
        $transaksi->load('detailTransaksi.produk');

        return view('riwayat-pesanan.show', compact('transaksi'));
    }
}