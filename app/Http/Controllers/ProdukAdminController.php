<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ProdukAdminController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $produks = Produk::with('stok')->latest()->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * [FIXED] Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (termasuk 'jumlah' untuk stok)
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required|integer|min:0',
        ]);

        // 2. Handle Upload Gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Pisahkan data produk, lalu simpan produk
        $produkData = Arr::except($validatedData, ['jumlah']);
        $produk = Produk::create($produkData);

        // 4. Buat data stok yang berelasi dengan produk baru
        $produk->stok()->create([
            'jumlah' => $validatedData['jumlah'],
            'status_stok' => 'tersedia',
            'tanggal_cek' => now(),
        ]);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * [FIXED] Memperbarui data produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required|integer|min:0',
        ]);

        // 2. Handle Upload Gambar
        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Update data di tabel 'produk'
        $produk->update(Arr::except($validatedData, ['jumlah']));

        // 4. Update atau Buat data di tabel 'stok'
        $produk->stok()->updateOrCreate(
            ['id_produk' => $produk->id],
            [
                'jumlah' => $validatedData['jumlah'],
                'status_stok' => 'tersedia',
                'tanggal_cek' => now(),
            ]
        );

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * [IMPROVED] Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        // Hapus gambar dari storage
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        
        // Hapus data stok yang berelasi terlebih dahulu
        $produk->stok()->delete();
        
        // Hapus data produk
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}