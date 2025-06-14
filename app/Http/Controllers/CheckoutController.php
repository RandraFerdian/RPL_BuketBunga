<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout untuk item dari KERANJANG BELANJA.
     */
    public function showCheckoutPage()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang Anda kosong!');
        }

        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }
        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Menyiapkan data untuk "BELI SEKARANG" lalu mengalihkan ke halaman checkout.
     */
    public function showCheckoutNowPage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->product_id);
        $cart_checkout = [
            $produk->id => [
                "name" => $produk->nama_produk,
                "quantity" => (int)$request->quantity,
                "price" => $produk->harga,
                "image" => $produk->gambar
            ]
        ];
        session()->put('cart_checkout', $cart_checkout);
        return redirect()->route('checkout.show');
    }

    /**
     * Memproses pesanan dari KEDUA ALUR dan menyimpannya ke database.
     */
    public function processOrder(Request $request)
{
    // 1. Validasi Input (termasuk alamat pengiriman)
    $validatedData = $request->validate([
        'phone' => 'required|string|max:15',
        'alamat_pengiriman' => 'required|string|max:500', // Validasi alamat
        'metode_pembayaran' => 'required|in:online,cod',
    ]);

    $cart = session()->get('cart_checkout', session()->get('cart', []));
    if (empty($cart)) {
        return redirect()->route('katalog.index')->with('error', 'Sesi checkout berakhir, silakan coba lagi.');
    }

    $totalHarga = 0;
    foreach ($cart as $details) { $totalHarga += $details['price'] * $details['quantity']; }

    // 2. Simpan Transaksi Utama (termasuk alamat)
    $transaksi = Transaksi::create([
        'id_user' => Auth::id(),
        'tanggal_transaksi' => now(),
        'total_harga' => $totalHarga,
        'alamat_pengiriman' => $validatedData['alamat_pengiriman'], // <-- Menyimpan alamat
        'metode_pembayaran' => $validatedData['metode_pembayaran'],
        'status_pembayaran' => 'belum lunas',
        'status_konfirmasi' => 'menunggu',
    ]);

    // 3. Simpan Detail Transaksi
    foreach ($cart as $id => $details) {
        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id,
            'id_produk' => $id,
            'jumlah' => $details['quantity'],
            'harga_satuan' => $details['price'], 
        ]);
    }

    // Hapus session setelah berhasil
    session()->forget(['cart', 'cart_checkout']);

    // Alihkan ke halaman konfirmasi yang sesuai
    if ($request->metode_pembayaran === 'cod') {
        return redirect()->route('order.cod_confirmation', $transaksi);
    } else {
        return redirect()->route('order.confirmation', $transaksi);
    }
}

    /**
     * Menampilkan halaman konfirmasi pembayaran online.
     */
    public function showConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id() && !Auth::user()->role === 'admin') {
            abort(403);
        }
        return view('order-confirmation', compact('transaksi'));
    }

    /**
     * Menampilkan halaman konfirmasi COD.
     */
    public function showCodConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id() && !Auth::user()->role === 'admin') {
            abort(403);
        }
        return view('cod-confirmation', compact('transaksi'));
    }
}