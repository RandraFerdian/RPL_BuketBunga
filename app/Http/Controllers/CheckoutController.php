<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout dengan detail produk
    public function showCheckoutPage(Request $request)
    {
        $produk = Produk::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $totalHarga = $produk->harga * $quantity;

        return view('checkout', compact('produk', 'quantity', 'totalHarga'));
    }

    // Memproses pesanan dan menyimpannya ke database
    public function processOrder(Request $request)
    {
        // Validasi sederhana
        $request->validate(['phone' => 'required|string|max:15']);

        // Simpan transaksi ke tabel 'transaksi'
        $transaksi = Transaksi::create([
            'id_user' => Auth::id(),
            'tanggal_transaksi' => Carbon::now(),
            'total_harga' => $request->total_harga,
            'metode_pembayaran' => 'transfer', // default
            'status_pembayaran' => 'belum lunas',
            'status_konfirmasi' => 'menunggu',
        ]);

        // Di aplikasi nyata, Anda akan membuat detail transaksi di sini
        //
        // $transaksi->detail()->create([
        //     'id_produk' => $request->product_id,
        //     'jumlah' => $request->quantity,
        //     'harga_satuan' => Produk::find($request->product_id)->harga,
        // ]);

        // Redirect ke halaman konfirmasi dengan membawa data transaksi baru
        return redirect()->route('order.confirmation', ['transaksi' => $transaksi->id]);
    }

    // Menampilkan halaman konfirmasi pembayaran
    public function showConfirmationPage(Transaksi $transaksi)
    {
        // Pastikan hanya user yang membuat transaksi yang bisa melihatnya
        if ($transaksi->id_user !== Auth::id()) {
            abort(403);
        }
        return view('order-confirmation', compact('transaksi'));
    }
}