@extends('layouts.app')
@section('title', 'Checkout - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-playfair font-bold text-center mb-10">Konfirmasi Pesanan Anda</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-gray-50 p-8 rounded-lg shadow-sm space-y-8">
                    
                    {{-- Detail Pelanggan --}}
                    <div>
                        <h2 class="text-2xl font-semibold mb-6">Detail Pelanggan</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200" readonly>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200" readonly>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon (WhatsApp)</label>
                                <input type="text" id="phone" name="phone" placeholder="Contoh: 08123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>
                    </div>

                    {{-- ====================================================== --}}
                    {{-- ==== REVISI: MENAMBAHKAN PILIHAN METODE PEMBAYARAN ==== --}}
                    {{-- ====================================================== --}}
                    <div>
                        <h3 class="text-2xl font-semibold mb-6">Metode Pembayaran</h3>
                        <div class="mt-4 space-y-4">
                            <label for="payment_online" class="flex items-center p-4 border border-gray-300 rounded-lg has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 cursor-pointer">
                                <input id="payment_online" name="metode_pembayaran" type="radio" value="online" checked class="h-4 w-4 text-pink-600 border-gray-300 focus:ring-pink-500">
                                <span class="ms-3 block text-sm font-medium text-gray-700">
                                    <span class="font-bold">QRIS / GoPay / E-Wallet</span>
                                    <span class="block text-xs text-gray-500">Pembayaran online aman dan cepat.</span>
                                </span>
                            </label>
                            <label for="payment_cod" class="flex items-center p-4 border border-gray-300 rounded-lg has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 cursor-pointer">
                                <input id="payment_cod" name="metode_pembayaran" type="radio" value="cod" class="h-4 w-4 text-pink-600 border-gray-300 focus:ring-pink-500">
                                <span class="ms-3 block text-sm font-medium text-gray-700">
                                    <span class="font-bold">COD (Bayar di Toko)</span>
                                    <span class="block text-xs text-gray-500">Ambil pesanan Anda dan bayar tunai langsung di toko.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 p-8 rounded-lg shadow-sm self-start sticky top-28">
                    <h2 class="text-2xl font-semibold mb-6">Ringkasan Pesanan</h2>
                    <div class="space-y-4">
                        @php $total = 0 @endphp
                        @foreach ($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-medium">{{ $details['name'] }}</p>
                                    <p class="text-gray-500">Rp{{ number_format($details['price']) }} x {{ $details['quantity'] }}</p>
                                </div>
                                <span class="font-medium">Rp{{ number_format($details['price'] * $details['quantity']) }}</span>
                            </div>
                        @endforeach

                        <div class="border-t my-4"></div>
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total Pembayaran</span>
                            <span>Rp{{ number_format($total) }}</span>
                        </div>
                    </div>
                    <button type="submit" class="mt-8 w-full px-8 py-4 bg-pink-500 text-white font-bold rounded-lg text-lg hover:bg-pink-600 transition-colors shadow-lg">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection