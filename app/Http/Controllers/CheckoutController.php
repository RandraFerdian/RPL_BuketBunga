<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * ALUR 1: Menampilkan halaman checkout untuk item dari KERANJANG BELANJA.
     * Logika ini membaca data dari Session.
     */
    public function showCheckoutPage()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            // Jika keranjang kosong, kembalikan ke katalog
            return redirect()->route('katalog.index')->with('error', 'Keranjang Anda kosong!');
        }

        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        // Kirim data keranjang dan total harga ke view yang sama
        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * ALUR 2: Menampilkan halaman checkout untuk "BELI SEKARANG".
     * Logika ini membaca data dari Request (form di halaman detail).
     */
    public function showCheckoutNowPage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->product_id);
        $quantity = (int)$request->quantity;
        $totalHarga = $produk->harga * $quantity;

        // Kita "simulasikan" struktur data keranjang, tapi hanya dengan satu item ini.
        $cart = [
            $produk->id => [
                "name" => $produk->nama_produk,
                "quantity" => $quantity,
                "price" => $produk->harga,
                "image" => $produk->gambar
            ]
        ];

        // Simpan "keranjang simulasi" ini ke session agar bisa diproses.
        session()->put('cart_checkout', $cart);

        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Memproses pesanan dari KEDUA ALUR dan menyimpannya ke database.
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15',
            'metode_pembayaran' => 'required|in:online,cod', // Validasi pilihan pembayaran
        ]);
    
        $cart = session()->get('cart_checkout', session()->get('cart', []));
        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Tidak ada item untuk di-checkout!');
        }
    
        $totalHarga = 0;
        foreach ($cart as $details) { $totalHarga += $details['price'] * $details['quantity']; }
    
        // Simpan transaksi ke database dengan metode pembayaran yang dipilih
        $transaksi = Transaksi::create([
            'id_user' => Auth::id(),
            'tanggal_transaksi' => Carbon::now(),
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->metode_pembayaran, // <-- Mengambil dari pilihan user
            'status_pembayaran' => 'belum lunas',
            'status_konfirmasi' => 'menunggu',
        ]);
    
        foreach ($cart as $id => $details) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id, 'id_produk' => $id,
                'jumlah' => $details['quantity'], 'harga_satuan' => $details['price'],
            ]);
        }
    
        session()->forget('cart');
        session()->forget('cart_checkout');
    
        // LOGIKA PENGALIHAN BERDASARKAN METODE PEMBAYARAN
        if ($request->metode_pembayaran === 'cod') {
            return redirect()->route('order.cod_confirmation', ['transaksi' => $transaksi->id]);
        } else {
            return redirect()->route('order.confirmation', ['transaksi' => $transaksi->id]);
        }
    }

    /**
     * Menampilkan halaman konfirmasi pembayaran.
     */
    public function showConfirmationPage(Transaksi $transaksi)
    {
        // Pastikan hanya user yang membuat transaksi yang bisa melihatnya
        if ($transaksi->id_user !== Auth::id()) {
            abort(403);
        }
        return view('order-confirmation', compact('transaksi'));
    }

    public function showCodConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('cod-confirmation', compact('transaksi'));
    }
}