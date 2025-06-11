<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class PesananAdminController extends Controller
{
    // Menampilkan daftar semua pesanan
    public function index()
    {
        // Ganti nama variabel dari $transaksi menjadi $pesanans
        $pesanans = Transaksi::with('user')->latest()->paginate(15);
        // Kirim 'pesanans' ke view
        return view('admin.pesanan.index', compact('pesanans'));
    }

    // Menampilkan detail satu pesanan
    public function show(Transaksi $transaksi)
    {
        // Sekarang kita load juga relasi 'produks'
        $transaksi->load('user', 'produks');
        return view('admin.pesanan.show', compact('transaksi'));
    }

    // Memperbarui status pesanan
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_konfirmasi' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $transaksi->status_konfirmasi = $request->status_konfirmasi;
        $transaksi->save();

        return redirect()->route('admin.pesanan.show', $transaksi)->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function updatePaymentStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum lunas,dibatalkan',
        ]);

        $transaksi->status_pembayaran = $request->status_pembayaran;
        $transaksi->save();

        return redirect()->route('admin.pesanan.show', $transaksi)->with('success', 'Status PEMBAYARAN berhasil diperbarui!');
    }
}
