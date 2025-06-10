@extends('layouts.app')
@section('title', 'Kategori: ' . $kategori . ' - Daara Bouquet')

@section('content')
    <section class="bg-pink-50">
        <div class="container mx-auto px-6 py-16 text-center">
            <p class="text-lg text-pink-600">Menampilkan Kategori</p>
            <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">{{ $kategori }}</h1>
        </div>
    </section>

    <div class="container mx-auto px-6 py-12">
        @if($products->isEmpty())
            <div class="text-center py-16">
                <p class="text-2xl text-gray-500">Oops! Belum ada produk di kategori ini.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-block px-8 py-3 bg-gray-800 text-white font-bold rounded-lg hover:bg-gray-700">Kembali ke Katalog</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    {{-- Menggunakan kembali kartu produk kita yang rapi --}}
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-12">{{ $products->links() }}</div>
        @endif
    </div>
@endsection