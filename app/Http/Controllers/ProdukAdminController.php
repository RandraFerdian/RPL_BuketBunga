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
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari form, termasuk 'jumlah' untuk stok
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah' => 'required|integer|min:0',
        ]);

        // 2. Handle Upload Gambar (jika ada)
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Pisahkan data produk dari data stok
        $produkData = Arr::except($validatedData, ['jumlah']);
        
        // 4. Buat record baru di tabel 'produk'
        $produk = Produk::create($produkData);

        // 5. Buat record baru di tabel 'stok' yang berelasi dengan produk
        $produk->stok()->create([
            'jumlah' => $validatedData['jumlah'],
            'status_stok' => 'tersedia', // Memberikan nilai default
            'tanggal_cek' => now(),      // Memberikan nilai tanggal & waktu saat ini
        ]);

        // 6. Arahkan kembali ke halaman daftar produk dengan pesan sukses
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
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'ukuran' => 'required|in:petite,small,medium,large,extra large,custom',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'jumlah' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $validatedData['gambar'] = $path;
        }

        $produk->update(Arr::except($validatedData, ['jumlah']));

        $produk->stok()->updateOrCreate(
            ['id_produk' => $produk->id],
            ['jumlah' => $validatedData['jumlah']]
        );

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        
        $produk->stok()->delete();
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
