<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public function reorder(Transaksi $transaksi)
    {
        // 1. Pastikan user hanya bisa memesan ulang transaksinya sendiri
        if ($transaksi->id_user !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // 2. Kosongkan keranjang yang ada saat ini
        Session::forget('cart');

        // 3. Loop melalui setiap produk di transaksi lama dan tambahkan ke keranjang baru
        foreach ($transaksi->produks as $produk) {
            $cart = session()->get('cart', []);

            // Menggunakan ID produk sebagai kunci
            $cart[$produk->id] = [
                "name"      => $produk->nama_produk,
                "quantity"  => $produk->pivot->jumlah, // Ambil jumlah dari pesanan lama
                "price"     => $produk->harga, // Ambil harga TERBARU dari produk
                "image"     => $produk->gambar
            ];
            session()->put('cart', $cart);
        }

        // 4. Arahkan pengguna ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Semua item dari pesanan #' . $transaksi->id . ' telah ditambahkan kembali ke keranjang!');
    }
}