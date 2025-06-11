@props(['product'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group transform hover:-translate-y-2 transition-transform duration-300">
    
    {{-- ====================================================== --}}
    {{-- ==== REVISI: Menggunakan blok gambar dari kode awal Anda ==== --}}
    {{-- ====================================================== --}}
    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden">
        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
    </div>

    {{-- =================================================================== --}}
    {{-- ==== Bagian Teks & Tombol diambil dari revisi terakhir kita ==== --}}
    {{-- =================================================================== --}}
    <div class="p-5 flex flex-col flex-grow">
        <p class="text-sm text-gray-500 uppercase tracking-wider">
             <a href="{{ route('katalog.kategori', $product->kategori) }}" class="hover:text-pink-500">
                {{ $product->kategori }}
            </a>
        </p>
        
        <h3 class="mt-1 text-lg font-bold text-gray-900 min-h-[3.5rem]" title="{{ $product->nama_produk }}">
            <a href="{{ route('katalog.show', $product->id) }}" class="hover:text-pink-500">
                {{ $product->nama_produk }}
            </a>
        </h3>

        <p class="mt-2 text-xl font-semibold text-pink-600">
            Rp{{ number_format($product->harga, 0, ',', '.') }}
        </p>
        
        <div class="mt-4 pt-4 border-t border-gray-100 flex-grow flex items-end">
            <div class="flex space-x-2 w-full">
                <a href="{{ route('katalog.show', $product->id) }}" class="flex-1 text-center px-4 py-2 bg-white text-pink-600 border border-pink-600 rounded-lg hover:bg-pink-600 hover:text-white transition-colors text-sm font-semibold">
                    Detail
                </a>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors text-sm font-semibold flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Keranjang</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
