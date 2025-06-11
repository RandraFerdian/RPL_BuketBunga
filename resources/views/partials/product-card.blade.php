@props(['product'])

<div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">
    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
        {{-- ========================================================== --}}
        {{-- INI ADALAH KODE YANG DIPERBAIKI --}}
        {{-- ========================================================== --}}
        <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
    </div>
    <div class="p-4">
        <h3 class="text-sm text-gray-500">
            <a href="{{ route('katalog.kategori', $product->kategori) }}">
                {{ $product->kategori }}
            </a>
        </h3>
        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $product->nama }}</p>
        <p class="mt-2 text-xl font-bold text-pink-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        
        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('katalog.show', $product->id) }}" class="text-sm font-semibold text-pink-600 hover:text-pink-800">Lihat Detail</a>
            
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-xs font-bold uppercase rounded-full hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                    + Keranjang
                </button>
            </form>
        </div>
    </div>
</div>
