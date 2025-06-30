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
            <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                {{-- Blok untuk menampilkan SEMUA error validasi di bagian atas --}}
                @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nama_produk') }}" required>
                    </div>

                    {{-- ============================================= --}}
                    {{-- ============ INPUT YANG HILANG ============ --}}
                    {{-- ============================================= --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->nama_kategori }}" @if(old('kategori')==$kategori->nama_kategori) selected @endif>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="mb-4">
                            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="MONEY BOUQUET" @if(old('kategori')=='MONEY BOUQUET' ) selected @endif>MONEY BOUQUET</option>
                                <option value="ARTIFICIAL FLOWERS BOUQUET" @if(old('kategori')=='ARTIFICIAL FLOWERS BOUQUET' ) selected @endif>ARTIFICIAL FLOWERS BOUQUET</option>
                                <option value="SNACK BOUQUET" @if(old('kategori')=='SNACK BOUQUET' ) selected @endif>SNACK BOUQUET</option>
                                <option value="BOUQUET BONEKA" @if(old('kategori')=='BOUQUET BONEKA' ) selected @endif>BOUQUET BONEKA</option>
                                <option value="BUTTERFLY BOUQUET" @if(old('kategori')=='BUTTERFLY BOUQUET' ) selected @endif>BUTTERFLY BOUQUET</option>
                                <option value="PIPE FLOWERS BOUQUET" @if(old('kategori')=='PIPE FLOWERS BOUQUET' ) selected @endif>PIPE FLOWERS BOUQUET</option>
                                <option value="BOUQUET FOTO" @if(old('kategori')=='BOUQUET FOTO' ) selected @endif>BOUQUET FOTO</option>
                                <option value="BAG & BLOOM BOX" @if(old('kategori')=='BAG & BLOOM BOX' ) selected @endif>BAG & BLOOM BOX</option>
                                <option value="FIGURA" @if(old('kategori')=='FIGURA' ) selected @endif>FIGURA</option>
                                {{-- Tambahkan kategori lain jika perlu --}}
                            </select>
                        </div> -->
                        <div class="mb-4">
                            <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                            <select name="ukuran" id="ukuran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" disabled selected>Pilih Ukuran</option>
                                <option value="petite" @if(old('ukuran')=='petite' ) selected @endif>Petite</option>
                                <option value="small" @if(old('ukuran')=='small' ) selected @endif>Small</option>
                                <option value="medium" @if(old('ukuran')=='medium' ) selected @endif>Medium</option>
                                <option value="large" @if(old('ukuran')=='large' ) selected @endif>Large</option>
                                <option value="extra large" @if(old('ukuran')=='extra large' ) selected @endif>Extra Large</option>
                                <option value="custom" @if(old('ukuran')=='custom' ) selected @endif>Custom</option>
                            </select>
                        </div>
                    </div>
                    {{-- ============================================= --}}

                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga" step="5000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('harga') }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                            <input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('jumlah') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" name="gambar" id="gambar" class="mt-1 block w-full">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.produk.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
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