<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class PesananAdminController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        $pesanan = Transaksi::with('user')->latest()->paginate(15);
        return view('admin.pesanan.index', compact('pesanan'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Transaksi $pesanan)
    {
        $pesanan->load('user', 'detailTransaksi.produk'); 
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function update(Request $request, Transaksi $pesanan)
    {
        $request->validate([
            'status_konfirmasi' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $pesanan->status_konfirmasi = $request->status_konfirmasi;
        $pesanan->save();

        return redirect()->route('admin.pesanan.show', $pesanan)->with('success', 'Status pesanan berhasil diperbarui!');
    }
}