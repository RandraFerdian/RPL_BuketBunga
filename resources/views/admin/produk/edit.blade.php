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
                    @method('PUT') {{-- Method untuk update --}}

                    <div class="mb-4">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                    </div>
                    
                    {{-- Tambahkan field lain (kategori, ukuran, harga, deskripsi) dengan cara yang sama, menggunakan value="..." --}}

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