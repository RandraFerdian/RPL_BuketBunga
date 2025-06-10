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
        // Kita belum punya detail transaksi, jadi kita lewati dulu
        // $transaksi->load('user', 'detailTransaksi.produk'); 
        $transaksi->load('user');
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

        return redirect()->route('pesanan.show', $transaksi)->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
