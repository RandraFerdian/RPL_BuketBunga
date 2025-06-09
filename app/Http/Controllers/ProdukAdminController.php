<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class ProdukAdminController extends Controller
{
    /**
     * Menampilkan daftar semua produk (Read).
     */
    public function index()
    {
        $produks = Produk::latest()->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menampilkan form untuk membuat produk baru (Create form).
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Menyimpan produk baru ke database (Store).
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // 2. Handle Upload Gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Simpan ke Database
        Produk::create($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk (Edit form).
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Memperbarui data produk di database (Update).
     */
    public function update(Request $request, Produk $produk)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            // Simpan gambar baru
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        $produk->update($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database (Delete).
     */
    public function destroy(Produk $produk)
    {
        // Hapus gambar dari storage
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
