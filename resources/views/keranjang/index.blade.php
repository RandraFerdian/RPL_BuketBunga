@extends('layouts.app')
@section('title', 'Keranjang Belanja - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-playfair font-bold text-center mb-10">Keranjang Belanja Anda</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">{{ session('success') }}</div>
        @endif

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @php $total = 0 @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div class="flex items-center bg-gray-50 p-4 rounded-lg shadow-sm">
                            <img src="{{ $details['image'] ? asset('storage/' . $details['image']) : 'https://via.placeholder.com/100' }}" alt="{{ $details['name'] }}" class="w-24 h-24 object-cover rounded-md">
                            <div class="flex-grow ml-4">
                                <p class="font-bold text-lg">{{ $details['name'] }}</p>
                                <p class="text-gray-600">Rp{{ number_format($details['price']) }}</p>
                                <div class="flex items-center mt-2">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 text-center border-gray-300 rounded-l-md">
                                        <button type="submit" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r-md text-sm">Update</button>
                                    </form>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            <p class="font-semibold text-lg">Rp{{ number_format($details['price'] * $details['quantity']) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gray-50 p-8 rounded-lg shadow-sm self-start sticky top-28">
                    <h2 class="text-2xl font-semibold mb-6">Ringkasan</h2>
                    <div class="flex justify-between text-xl font-bold">
                        <span>Total</span>
                        <span>Rp{{ number_format($total) }}</span>
                    </div>
                    <a href="{{ route('checkout.show') }}" class="mt-8 block w-full text-center px-8 py-4 bg-pink-500 text-white font-bold rounded-lg text-lg hover:bg-pink-600 transition-colors shadow-lg">
                        Lanjutkan ke Checkout
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-2xl text-gray-500">Keranjang belanja Anda kosong.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-block px-8 py-3 bg-gray-800 text-white font-bold rounded-lg hover:bg-gray-700">Mulai Belanja</a>
            </div>
        @endif
    </div>
</div>
@endsection