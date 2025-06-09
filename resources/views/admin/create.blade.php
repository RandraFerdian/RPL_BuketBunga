<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Isi form seperti nama_produk, kategori, harga, dll. --}}
                        <div class="mb-4">
                            <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        {{-- Tambahkan input lain untuk kategori, ukuran (select), harga, deskripsi (textarea), dan gambar (file) --}}
                        <div class="mb-4">
                            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                            <input type="file" name="gambar" id="gambar" class="mt-1 block w-full">
                        </div>

                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
                            <a href="{{ route('produk.index') }}" class="px-4 py-2 bg-gray-300 rounded-md">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>