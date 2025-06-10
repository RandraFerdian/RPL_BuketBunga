@extends('layouts.app')
@section('title', 'Katalog Produk - Daara Bouquet')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        {{-- REVISI: Judul dinamis yang bisa menampilkan hasil pencarian --}}
        @if(isset($query))
            <h1 class="text-4xl font-playfair font-bold text-gray-800">Hasil Pencarian</h1>
            <p class="mt-4 text-lg text-gray-600">Menampilkan hasil untuk: "<span class="font-semibold text-pink-500">{{ $query }}</span>"</p>
        @else
            <h1 class="text-4xl font-playfair font-bold text-gray-800">Koleksi Kami</h1>
            <p class="mt-4 text-lg text-gray-600">Temukan buket yang sempurna untuk setiap kesempatan.</p>
        @endif
    </div>

    {{-- Menampilkan pesan jika tidak ada produk yang ditemukan --}}
    @if($products->isEmpty())
        <div class="text-center py-16">
            <p class="text-2xl text-gray-500">Oops! Produk tidak ditemukan.</p>
            <a href="{{ route('katalog.index') }}" class="mt-6 inline-block px-8 py-3 bg-gray-800 text-white font-bold rounded-lg hover:bg-gray-700">Kembali ke Katalog</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            {{-- Looping untuk setiap produk --}}
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-full h-64 bg-gray-200 overflow-hidden">
                        {{-- REVISI: Menampilkan gambar produk asli dari storage --}}
                        <a href="{{ route('katalog.show', $product->id) }}">
                            @if($product->gambar && Storage::disk('public')->exists($product->gambar))
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://via.placeholder.com/400x400.png/fce7f3/9d174d?text=DaaraBQT" alt="Gambar placeholder" class="w-full h-full object-cover">
                            @endif
                        </a>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-sm text-gray-500">{{ $product->kategori }}</p>
                        <h3 class="mt-1 text-lg font-bold text-gray-900 truncate" title="{{ $product->nama_produk }}">
                            <a href="{{ route('katalog.show', $product->id) }}" class="hover:text-pink-500">{{ $product->nama_produk }}</a>
                        </h3>
                        <p class="mt-2 text-xl font-semibold text-pink-600">
                            Rp{{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                        
                        {{-- REVISI: Menambahkan dua tombol aksi --}}
                        <div class="mt-4 pt-4 border-t border-gray-200 flex-grow flex items-end">
                            <div class="flex space-x-2 w-full">
                                <a href="{{ route('katalog.show', $product->id) }}" class="flex-1 text-center px-4 py-2 bg-white text-pink-600 border border-pink-600 rounded-lg hover:bg-pink-600 hover:text-white transition-colors text-sm font-semibold">
                                    Detail
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors text-sm font-semibold">
                                        + Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Menampilkan link paginasi --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection