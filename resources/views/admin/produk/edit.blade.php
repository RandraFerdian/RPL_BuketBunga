@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk: {{ $produk->nama_produk }}
        </h2>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <form method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('kategori', $produk->kategori) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                        <select name="ukuran" id="ukuran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="petite" {{ old('ukuran', $produk->ukuran) == 'petite' ? 'selected' : '' }}>Petite</option>
                            <option value="small" {{ old('ukuran', $produk->ukuran) == 'small' ? 'selected' : '' }}>Small</option>
                            <option value="medium" {{ old('ukuran', $produk->ukuran) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="large" {{ old('ukuran', $produk->ukuran) == 'large' ? 'selected' : '' }}>Large</option>
                            <option value="extra large" {{ old('ukuran', $produk->ukuran) == 'extra large' ? 'selected' : '' }}>Extra Large</option>
                            <option value="custom" {{ old('ukuran', $produk->ukuran) == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('harga', $produk->harga) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    {{-- ============================================= --}}
                    {{-- ============ INPUT STOK YANG BARU ============ --}}
                    {{-- ============================================= --}}
                    <div class="mb-4">
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                        <input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('jumlah', $produk->stok->jumlah ?? 0) }}" required>
                    </div>
                    {{-- ============================================= --}}

                    <div class="mb-4">
                        <label for="gambar" class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-32 h-32 object-cover rounded my-2">
                        @endif
                        <input type="file" name="gambar" id="gambar" class="mt-1 block w-full">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('produk.index') }}" class="text-gray-600 mr-4">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection