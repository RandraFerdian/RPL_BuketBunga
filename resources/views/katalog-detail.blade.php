{{-- Memberitahu Blade untuk menggunakan layout 'app.blade.php' --}}
@extends('layouts.app')

{{-- Mengatur judul halaman secara dinamis berdasarkan nama produk --}}
@section('title', $produk->nama_produk . ' - Daara Bouquet')

{{-- Mendefinisikan konten utama untuk halaman ini --}}
@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        
        {{-- Tombol untuk kembali ke halaman katalog --}}
        <div class="mb-8">
            <a href="{{ route('katalog.index') }}" class="text-gray-500 hover:text-gray-800 transition-colors inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <div class="w-full sticky top-28">
                <div class="bg-gray-100 rounded-lg shadow-lg overflow-hidden">
                    @if($produk->gambar && Storage::disk('public')->exists($produk->gambar))
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar {{ $produk->nama_produk }}" class="w-full h-auto object-cover aspect-square">
                    @else
                        {{-- Placeholder jika gambar tidak ada --}}
                        <div class="w-full h-auto object-cover aspect-square flex items-center justify-center bg-gray-200">
                            <span class="text-gray-500">Gambar tidak tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                {{-- Kategori Produk --}}
                <p class="text-sm font-semibold text-pink-500 uppercase tracking-wider">{{ $produk->kategori }}</p>

                {{-- Nama Produk --}}
                <h1 class="mt-2 text-4xl md:text-5xl font-playfair font-bold text-gray-900">{{ $produk->nama_produk }}</h1>
                
                {{-- Harga Produk --}}
                <p class="mt-4 text-4xl font-light text-gray-800">
                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                <div class="mt-6 border-t pt-6">
                    {{-- Pilihan Ukuran --}}
                    <div class="flex items-center">
                        <label for="ukuran" class="text-base font-medium text-gray-900 w-24">Ukuran:</label>
                        <span class="px-4 py-2 bg-pink-100 text-pink-800 font-semibold rounded-full">{{ ucfirst($produk->ukuran) }}</span>
                    </div>
                </div>

                {{-- Deskripsi Produk --}}
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Deskripsi Produk</h3>
                    <div class="text-gray-600 leading-relaxed space-y-4 prose">
                        {{-- nl2br(e(...)) digunakan agar enter/baris baru di deskripsi bisa tampil di HTML --}}
                        {!! nl2br(e($produk->deskripsi ?: 'Tidak ada deskripsi untuk produk ini.')) !!}
                    </div>
                </div>

                {{-- Tombol Aksi (Pesan) --}}
                <form action="{{ route('checkout.show') }}" method="POST" x-data="{ quantity: 1 }">
                    @csrf
                    {{-- Mengirim ID produk secara tersembunyi --}}
                    <input type="hidden" name="product_id" value="{{ $produk->id }}">

                    <div class="mt-8 flex items-center space-x-6">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" @click="if (quantity > 1) quantity--" class="px-4 py-2 text-lg font-bold text-gray-700 hover:bg-gray-200 rounded-l-lg">-</button>
                            <input type="text" name="quantity" x-model="quantity" class="w-16 text-center font-bold border-t border-b border-gray-300 focus:outline-none">
                            <button type="button" @click="quantity++" class="px-4 py-2 text-lg font-bold text-gray-700 hover:bg-gray-200 rounded-r-lg">+</button>
                        </div>
                        <p class="text-sm text-gray-500">Jumlah</p>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full px-8 py-4 bg-gray-800 text-white font-bold rounded-lg text-lg hover:bg-gray-700 transition-colors shadow-lg">
                            Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection