<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang belanja
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('keranjang.index', compact('cart'));
    }

    // Menambahkan produk ke keranjang
    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:produk,id']);
        
        $produk = Produk::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        if(isset($cart[$produk->id])) {
            $cart[$produk->id]['quantity'] += $quantity;
        } else {
            // Jika belum, tambahkan sebagai item baru
            $cart[$produk->id] = [
                "name" => $produk->nama_produk,
                "quantity" => $quantity,
                "price" => $produk->harga,
                "image" => $produk->gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Memperbarui jumlah produk di keranjang
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart');
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    // Menghapus produk dari keranjang
    public function remove($id)
    {
        $cart = session()->get('cart');
    
        if(isset($cart[$id])) {
            unset($cart[$id]); // Hapus item dari array berdasarkan ID dari URL
            session()->put('cart', $cart);
        }
    
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}