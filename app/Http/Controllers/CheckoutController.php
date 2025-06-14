<?php

namespace App\Http\Controllers;

// Pastikan semua Model dan Facade yang dibutuhkan sudah di-import
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     * Kode ini sudah final dan mendukung alur "Beli Sekarang" & "Keranjang Belanja".
     */
    public function showCheckoutPage()
    {
        // Mengambil data dari 'cart_checkout' (untuk Beli Sekarang) atau dari 'cart'
        $cart = session()->get('cart_checkout', session()->get('cart', []));

        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang Anda kosong atau sesi checkout telah berakhir!');
        }

        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }
        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Menyiapkan data untuk "Beli Sekarang".
     * Kode ini sudah final dan benar.
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
     * [VERSI FINAL] Memproses pesanan dengan semua perbaikan.
     */
    public function processOrder(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|max:15',
            'alamat_pengiriman' => 'required|string|max:500',
            'metode_pembayaran' => 'required|in:online,cod',
        ]);
        
        $cart = session()->get('cart_checkout', session()->get('cart', []));
        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Sesi checkout berakhir, silakan coba lagi.');
        }

        // [FIX 1] Menggunakan Transaction untuk menjaga konsistensi data
        DB::beginTransaction();
        try {
            // [FIX 2] Validasi stok untuk setiap produk sebelum melanjutkan
            foreach ($cart as $id => $details) {
                $stok = Stok::where('id_produk', $id)->first();
                if (!$stok) {
                    DB::rollBack();
                    return redirect()->route('katalog.index')->with('error', 'Produk "' . $details['name'] . '" tidak dapat dipesan (stok tidak terdaftar).');
                }
                if ($stok->jumlah < $details['quantity']) {
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Stok untuk produk "' . $details['name'] . '" tidak mencukupi.');
                }
            }

            // Proses pembuatan transaksi jika semua stok aman
            $totalHarga = 0;
            foreach ($cart as $details) { $totalHarga += $details['price'] * $details['quantity']; }
            
            $transaksi = Transaksi::create([
                'id_user' => Auth::id(), 'tanggal_transaksi' => now(), 'total_harga' => $totalHarga,
                'alamat_pengiriman' => $validatedData['alamat_pengiriman'], 'metode_pembayaran' => $validatedData['metode_pembayaran'],
                'status_pembayaran' => 'belum lunas', 'status_konfirmasi' => 'menunggu',
            ]);

            foreach ($cart as $id => $details) {
                // [FIX 3] Mengisi kolom 'harga_saat_transaksi' untuk mengatasi error SQL
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $id,
                    'jumlah' => $details['quantity'],
                    'harga_satuan' => $details['price'],
                    'harga_saat_transaksi' => $details['price'], // <-- Perbaikan Error SQL
                ]);
                // [FIX 4] Mengurangi jumlah stok setelah pesanan berhasil dibuat
                Stok::where('id_produk', $id)->decrement('jumlah', $details['quantity']);
            }
            
            // [FIX 5] Menyimpan semua perubahan ke database jika tidak ada error
            DB::commit();
            // Membersihkan session setelah transaksi sukses
            session()->forget(['cart', 'cart_checkout']);

            // Mengarahkan ke halaman konfirmasi yang sesuai
            if ($request->metode_pembayaran === 'cod') {
                return redirect()->route('order.cod_confirmation', $transaksi);
            } else {
                return redirect()->route('order.confirmation', $transaksi);
            }

        } catch (\Exception $e) {
            // Jika ada error lain yang tak terduga, batalkan semua dan beri pesan
            DB::rollBack();
            return redirect()->route('katalog.index')->with('error', 'Terjadi kesalahan sistem saat memproses pesanan. Error: ' . $e->getMessage());
        }
    }

    public function showConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id() && Auth::user()->role !== 'admin') { abort(403); }
        return view('order-confirmation', compact('transaksi'));
    }

    public function showCodConfirmationPage(Transaksi $transaksi)
    {
        if ($transaksi->id_user !== Auth::id() && Auth::user()->role !== 'admin') { abort(403); }
        return view('cod-confirmation', compact('transaksi'));
    }
}