{{-- Memberitahu Blade untuk menggunakan layout 'app' --}}
@extends('layouts.app')

{{-- Mengatur judul spesifik untuk halaman ini --}}
@section('title', 'Katalog Produk - Daara Bouquet')

{{-- Mendefinisikan konten utama untuk halaman ini --}}
@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Koleksi Kami</h1>
        <p class="mt-4 text-lg text-gray-600">Temukan buket yang sempurna untuk setiap kesempatan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        {{-- Looping untuk setiap produk yang dikirim dari Controller --}}
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 hover:shadow-2xl transition-all duration-300 group">
                <div class="w-full h-64 bg-gray-200 overflow-hidden">
                    {{-- Ganti dengan gambar produk Anda --}}
                    <img src="https://via.placeholder.com/400x400.png/fce7f3/9d174d?text=DaaraBQT" alt="Gambar {{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>

                <div class="p-5">
                    <p class="text-sm text-gray-500">{{ $product->kategori }}</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-900 truncate" title="{{ $product->nama_produk }}">
                        {{ $product->nama_produk }}
                    </h3>
                    <p class="mt-2 text-xl font-semibold text-pink-600">
                        Rp{{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('katalog.show', $product->id) }}" class="mt-4 block w-full text-center bg-pink-600 text-white py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection