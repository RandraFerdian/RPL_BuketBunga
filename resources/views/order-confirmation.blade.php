@extends('layouts.app')
@section('title', 'Konfirmasi Pesanan - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6 text-center max-w-2xl">
        <svg class="mx-auto w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="text-4xl font-playfair font-bold mt-4">Terima Kasih Atas Pesanan Anda!</h1>
        <p class="mt-4 text-gray-600">Pesanan Anda dengan ID **#{{ $transaksi->id }}** telah kami terima. Mohon selesaikan pembayaran untuk kami proses lebih lanjut.</p>

        <div class="mt-8 p-6 border rounded-lg">
            <h2 class="text-xl font-semibold">Total Pembayaran:</h2>
            <p class="text-4xl font-bold text-pink-500 my-2">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

            <div class="mt-6">
                <h3 class="text-lg font-semibold">Silakan Lakukan Pembayaran via QRIS</h3>
                <p class="text-sm text-gray-500 mb-4">Scan QR code di bawah ini menggunakan aplikasi e-wallet Anda (GoPay, OVO, Dana, dll.)</p>
                {{-- Ganti dengan gambar QRIS Anda yang asli --}}
                <img src="https://i.imgur.com/g3v1v2f.png" alt="Contoh QRIS" class="mx-auto w-64 h-64 border p-2">
                <p class="mt-4 text-xs text-gray-500">**PENTING**: Ini adalah halaman simulasi. Pada aplikasi nyata, QR code ini akan unik untuk setiap transaksi.</p>
            </div>
        </div>

        <a href="{{ route('katalog.index') }}" class="mt-8 inline-block text-gray-600 hover:text-pink-500">
            &larr; Kembali Berbelanja
        </a>
    </div>
</div>
@endsection