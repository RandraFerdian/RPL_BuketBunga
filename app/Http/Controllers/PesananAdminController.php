<?php

namespace App\Http\Controllers;

use App\Models\Stok; // <-- IMPORT MODEL STOK
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- IMPORT DB FACADE

class PesananAdminController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->latest()->paginate(15);
        return view('admin.pesanan.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        // Muat relasi user dan detail transaksi beserta produk di dalamnya
        $transaksi->load('user', 'detailTransaksi.produk'); 
        return view('admin.pesanan.show', compact('transaksi'));
    }

    /**
     * [REVISI TOTAL] Memperbarui status pesanan (konfirmasi & pembayaran)
     * dan mengembalikan stok jika pesanan dibatalkan.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_konfirmasi' => 'sometimes|required|in:menunggu,diproses,selesai,dibatalkan',
            'status_pembayaran' => 'sometimes|required|in:lunas,belum lunas',
        ]);

        DB::beginTransaction();
        try {
            $statusKonfirmasiLama = $transaksi->status_konfirmasi;

            // Update status pembayaran jika ada di request
            if ($request->has('status_pembayaran')) {
                $transaksi->status_pembayaran = $request->status_pembayaran;
            }

            // Update status konfirmasi jika ada di request
            if ($request->has('status_konfirmasi')) {
                $statusKonfirmasiBaru = $request->status_konfirmasi;
                $transaksi->status_konfirmasi = $statusKonfirmasiBaru;

                // LOGIKA UTAMA: Jika status diubah menjadi 'dibatalkan'
                // dan status sebelumnya BUKAN 'dibatalkan', kembalikan stok.
                if ($statusKonfirmasiBaru === 'dibatalkan' && $statusKonfirmasiLama !== 'dibatalkan') {
                    // Muat relasi detailTransaksi jika belum ada
                    $transaksi->loadMissing('detailTransaksi');
                    
                    foreach ($transaksi->detailTransaksi as $detail) {
                        Stok::where('id_produk', $detail->id_produk)->increment('jumlah', $detail->jumlah);
                    }
                }
            }

            $transaksi->save();
            DB::commit();

            return redirect()->route('admin.pesanan.show', $transaksi)->with('success', 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pesanan.show', $transaksi)->with('error', 'Gagal memperbarui status. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        // Sebelum menghapus, pastikan stok sudah dikembalikan jika pesanan belum selesai/dibatalkan
        if ($transaksi->status_konfirmasi !== 'selesai' && $transaksi->status_konfirmasi !== 'dibatalkan') {
            $transaksi->loadMissing('detailTransaksi');
            foreach ($transaksi->detailTransaksi as $detail) {
                Stok::where('id_produk', $detail->id_produk)->increment('jumlah', $detail->jumlah);
            }
        }
        
        // Hapus detail transaksi terlebih dahulu
        $transaksi->detailTransaksi()->delete();
        $transaksi->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}