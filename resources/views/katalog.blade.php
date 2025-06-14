{{-- File: resources/views/katalog.blade.php (Versi Final) --}}

@extends('layouts.app')
@section('title', 'Katalog Produk - Daara Bouquet')

@section('content')
@if (session('error'))
    <div class="container mx-auto px-6 pt-6">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
            <p class="font-bold">Terjadi Error Saat Memproses Pesanan!</p>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif
    
    {{-- Bagian Banner --}}
    <section class="bg-pink-50">
        <div class="container mx-auto px-6 py-16 text-center">
            @if(isset($query))
                {{-- Tampilan Banner untuk Halaman Pencarian --}}
                <h1 class="text-4xl font-playfair font-bold text-gray-800">Hasil Pencarian</h1>
                <p class="mt-4 text-lg text-gray-600">Menampilkan hasil untuk: "<span class="font-semibold text-pink-500">{{ $query }}</span>"</p>
            @else
                {{-- Tampilan Banner untuk Halaman Katalog Utama --}}
                <h1 class="text-4xl md:text-5xl font-playfair font-bold text-gray-800">Koleksi Kami</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Temukan buket yang sempurna untuk setiap kesempatan, dirangkai dengan cinta dan ketelitian untuk momen berharga Anda.</p>
                
                {{-- Tombol Shortcut Kategori di dalam Banner --}}
                @if(isset($groupedProducts) && $groupedProducts->count() > 0)
                <div class="mt-8 flex justify-center flex-wrap gap-3">
                    @foreach ($groupedProducts->keys() as $kategori)
                        <a href="#kategori-{{ Str::slug($kategori) }}" class="px-5 py-2 bg-white border border-gray-300 rounded-full text-sm font-semibold text-gray-700 hover:bg-pink-500 hover:text-white hover:border-pink-500 transition-colors">
                            {{ $kategori }}
                        </a>
                    @endforeach
                </div>
                @endif
            @endif
        </div>
    </section>

    {{-- Bagian Konten Produk --}}
    <div class="container mx-auto px-6 py-12">
        @if(isset($groupedProducts) && $groupedProducts->count() > 0)
            {{-- Tampilan untuk KATALOG UTAMA (Dikelompokkan) --}}
            @foreach ($groupedProducts as $kategori => $productsInCategory)
                <section class="mb-16" id="kategori-{{ Str::slug($kategori) }}">
                    <div class="flex justify-between items-center border-b-2 border-pink-200 pb-4 mb-8">
                        <h2 class="text-3xl font-bold font-playfair">{{ $kategori }}</h2>
                        {{-- Tombol "Lihat Semua" jika produk lebih dari 4 --}}
                        @if($productsInCategory->count() > 4)
                            <a href="{{ route('katalog.kategori', ['kategori' => $kategori]) }}" class="px-4 py-2 bg-white text-pink-600 border border-pink-600 rounded-full text-sm font-semibold hover:bg-pink-600 hover:text-white transition-colors">
                                Lihat Semua &rarr;
                            </a>
                        @endif
                    </div>
                    
                    {{-- Grid untuk preview produk (hanya 4 produk) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($productsInCategory->take(4) as $product)
                            @include('partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </section>
            @endforeach

        @elseif(isset($products) && $products->count() > 0)
            {{-- Tampilan untuk HASIL PENCARIAN (Tidak Dikelompokkan) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-12">{{ $products->links() }}</div>
            
        @else
            {{-- Tampilan jika tidak ada produk sama sekali --}}
            <div class="text-center py-16">
                <p class="text-2xl text-gray-500">Oops! Produk tidak ditemukan.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-block px-8 py-3 bg-gray-800 text-white font-bold rounded-lg hover:bg-gray-700">Kembali ke Katalog</a>
            </div>
        @endif
    </div>
@endsection