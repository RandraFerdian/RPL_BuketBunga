@extends('layouts.app')
@section('title', 'Checkout - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-playfair font-bold text-center mb-10">Konfirmasi Pesanan Anda</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $produk->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
            <input type="hidden" name="total_harga" value="{{ $totalHarga }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-gray-50 p-8 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-semibold mb-6">Detail Pelanggan</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon (WhatsApp)</label>
                            <input type="text" id="phone" name="phone" placeholder="Contoh: 08123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-semibold mb-6">Ringkasan Pesanan</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ $produk->nama_produk }} (x{{ $quantity }})</span>
                            <span class="font-medium">Rp{{ number_format($produk->harga * $quantity) }}</span>
                        </div>
                        <div class="border-t my-4"></div>
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total Pembayaran</span>
                            <span>Rp{{ number_format($totalHarga) }}</span>
                        </div>
                    </div>
                    <button type="submit" class="mt-8 w-full px-8 py-4 bg-pink-500 text-white font-bold rounded-lg text-lg hover:bg-pink-600 transition-colors shadow-lg">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection