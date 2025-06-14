@extends('layouts.app')
@section('title', $produk->nama_produk . ' - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        
        <div class="mb-8">
            <a href="{{ route('katalog.index') }}" class="text-gray-500 hover:text-gray-800 transition-colors inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <div class="w-full sticky top-28">
                <div class="bg-gray-100 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar {{ $produk->nama_produk }}" class="w-full h-auto object-cover aspect-square">
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-pink-500 uppercase tracking-wider">{{ $produk->kategori }}</p>
                <h1 class="mt-2 text-4xl md:text-5xl font-playfair font-bold text-gray-900">{{ $produk->nama_produk }}</h1>
                <p class="mt-4 text-4xl font-light text-gray-800">
                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                <div class="mt-6 border-t pt-6">
                    <div class="flex items-center">
                        <label class="text-base font-medium text-gray-900 w-24">Ukuran:</label>
                        <span class="px-4 py-2 bg-pink-100 text-pink-800 font-semibold rounded-full">{{ ucfirst($produk->ukuran) }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Deskripsi Produk</h3>
                    <div class="text-gray-600 leading-relaxed space-y-4 prose max-w-none">
                        {!! nl2br(e($produk->deskripsi ?: 'Tidak ada deskripsi untuk produk ini.')) !!}
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- ==== REVISI: Logika Pengecekan Stok Ditambahkan ==== --}}
                {{-- ====================================================== --}}
                <div class="mt-10">
                    {{-- Cek apakah data stok ada DAN jumlahnya lebih dari 0 --}}
                    @if($produk->stok && $produk->stok->jumlah > 0)
                        <div x-data="{ quantity: 1, max_stock: {{ $produk->stok->jumlah }} }">
                            <p class="text-sm text-green-600 mb-4">Stok tersedia: {{ $produk->stok->jumlah }} buah</p>
                            <div class="flex items-center space-x-4 mb-6">
                                <p class="text-base font-medium text-gray-900 w-20">Jumlah:</p>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" @click="if (quantity > 1) quantity--" class="px-4 py-2 text-lg font-bold text-gray-700 hover:bg-gray-200 rounded-l-lg">-</button>
                                    <input type="text" x-model="quantity" class="w-16 text-center font-bold border-t border-b border-gray-300 focus:outline-none" readonly>
                                    {{-- Tombol + tidak akan berfungsi jika jumlah melebihi stok --}}
                                    <button type="button" @click="if (quantity < max_stock) quantity++" class="px-4 py-2 text-lg font-bold text-gray-700 hover:bg-gray-200 rounded-r-lg" :class="{ 'cursor-not-allowed': quantity >= max_stock }">+</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $produk->id }}">
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button type="submit" class="w-full h-full px-8 py-4 bg-pink-100 text-pink-700 font-bold rounded-lg text-lg hover:bg-pink-200 transition-colors">
                                        + Keranjang
                                    </button>
                                </form>

                                <form action="{{ route('checkout.now') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $produk->id }}">
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button type="submit" class="w-full h-full px-8 py-4 bg-gray-800 text-white font-bold rounded-lg text-lg hover:bg-gray-700 transition-colors shadow-lg">
                                        Beli Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Tampilan jika stok habis --}}
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-center">
                            <p class="font-bold text-red-700">Stok Habis</p>
                            <p class="text-sm text-red-600 mt-1">Mohon maaf, produk ini sedang tidak tersedia.</p>
                        </div>
                    @endif
                </div>
                {{-- ====================================================== --}}
                {{-- ================= END REVISI ======================= --}}
                {{-- ====================================================== --}}
            </div>
        </div>
    </div>
</div>
@endsection