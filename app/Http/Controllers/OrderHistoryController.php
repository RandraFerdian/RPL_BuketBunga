<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil transaksi hanya untuk user yang sedang login
        $transaksis = Transaksi::where('id_user', Auth::id())
                                ->latest() // Urutkan dari yang terbaru
                                ->paginate(10); // Gunakan pagination

        return view('riwayat-pesanan.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail satu pesanan dari riwayat.
     */
    public function show(Transaksi $transaksi)
    {
        // Pastikan user hanya bisa melihat detail transaksinya sendiri
        if ($transaksi->id_user !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Load relasi produk untuk ditampilkan di detail
        $transaksi->load('produks');

        return view('riwayat-pesanan.show', compact('transaksi'));
    }
}