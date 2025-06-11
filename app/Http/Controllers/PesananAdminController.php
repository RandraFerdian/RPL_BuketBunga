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
        // Menggunakan nama variabel jamak '$transaksis' untuk kumpulan data
        $transaksis = Transaksi::with('user')->latest()->paginate(15);
        return view('admin.pesanan.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail satu pesanan.
     * Menggunakan $transaksi agar sesuai dengan route model binding.
     * Memuat relasi 'produks' yang sudah kita definisikan di model.
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('user', 'produks'); 
        return view('admin.pesanan.show', compact('transaksi'));
    }

    /**
     * Memperbarui status konfirmasi pesanan.
     * Menggunakan $transaksi agar sesuai dengan route model binding.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_konfirmasi' => 'required|in:menunggu,diproses,selesai,dibatalkan',
        ]);

        $transaksi->status_konfirmasi = $request->status_konfirmasi;
        $transaksi->save();

        return redirect()->route('admin.pesanan.show', $transaksi)->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Memperbarui status PEMBAYARAN pesanan.
     * Method ini diambil dari 'cabangke2' dan disesuaikan.
     */
    public function updatePaymentStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum lunas,dibatalkan',
        ]);

        $transaksi->status_pembayaran = $request->status_pembayaran;
        $transaksi->save();

        return redirect()->route('admin.pesanan.show', $transaksi)->with('success', 'Status PEMBAYARAN berhasil diperbarui!');
    }
    
    /**
     * Menghapus pesanan.
     * Menggunakan $transaksi agar sesuai dengan route model binding.
     */
    public function destroy(Transaksi $transaksi)
    {
        // Logika untuk menghapus detail transaksi terkait sebelum menghapus transaksi utama
        $transaksi->produks()->detach(); // Menghapus record dari tabel pivot
        $transaksi->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}