@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                {{-- Form untuk menambah produk --}}
                <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                    @csrf  {{-- Token Keamanan Wajib --}}

                    <div class="mb-4">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" name="gambar" id="gambar" class="mt-1 block w-full">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600">
                            Simpan Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection