<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout dari keranjang atau "Beli Sekarang".
     */
    public function showCheckoutPage()
    {
        // Logika ini bisa digabung karena tujuannya sama
        $cart = session()->get('cart_checkout', session()->get('cart', []));

        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Tidak ada item untuk di-checkout!');
        }

        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Memproses data dari tombol "Beli Sekarang".
     */
    public function showCheckoutNowPage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->product_id);

        $cart = [
            $produk->id => [
                "name" => $produk->nama_produk,
                "quantity" => (int)$request->quantity,
                "price" => $produk->harga,
                "image" => $produk->gambar
            ]
        ];

        // Simpan ke session sementara dan alihkan ke halaman checkout utama
        session()->put('cart_checkout', $cart);
        return redirect()->route('checkout.show');
    }

    /**
     * [FIXED] Memproses pesanan dan menyimpannya ke database.
     */
    public function processOrder(Request $request)
    {
        // 1. Validasi Input (termasuk alamat pengiriman)
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'alamat_pengiriman' => 'required|string|max:255',
            'metode_pembayaran' => 'required|in:online,cod',
        ]);

        $cart = session()->get('cart_checkout', session()->get('cart', []));
        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Sesi checkout berakhir, silakan coba lagi.');
        }

        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        // 2. Simpan Transaksi Utama (tanpa tanggal_transaksi manual)
        // Di dalam method processOrder()

        $transaksi = Transaksi::create([
            'id_user' => Auth::id(),
            'tanggal_transaksi' => now(), // <-- TAMBAHKAN KEMBALI BARIS INI
            'total_harga' => $totalHarga,
            'alamat_pengiriman' => $validatedData['alamat_pengiriman'],
            'metode_pembayaran' => $validatedData['metode_pembayaran'],
            'status_pembayaran' => 'belum lunas',
            'status_konfirmasi' => 'menunggu',
        ]);

        // 3. Simpan Detail Transaksi menggunakan relasi (sudah benar)
        foreach ($cart as $id => $details) {
            $transaksi->produks()->attach($id, [
                'jumlah' => $details['quantity'],
                'harga_saat_transaksi' => $details['price'], // <-- Menggunakan nama kolom yang benar
            ]);
        }

        // Hapus session setelah berhasil
        session()->forget(['cart', 'cart_checkout']);

        // Alihkan ke halaman konfirmasi yang sesuai
        if ($request->metode_pembayaran === 'cod') {
            return redirect()->route('order.cod_confirmation', $transaksi->id);
        } else {
            return redirect()->route('order.confirmation', $transaksi->id);
        }
    }

    /**
     * Menampilkan halaman konfirmasi pembayaran.
     */
    public function showConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id()) {
            abort(403);
        }
        return view('order-confirmation', compact('transaksi'));
    }

    /**
     * Menampilkan halaman konfirmasi COD.
     */
    public function showCodConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id()) {
            abort(403);
        }
        return view('cod-confirmation', compact('transaksi'));
    }
}
