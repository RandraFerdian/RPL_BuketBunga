@extends('layouts.app')
@section('title', 'Konfirmasi Pesanan COD - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6 text-center max-w-2xl">
        <svg class="mx-auto w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="text-4xl font-playfair font-bold mt-4">Pesanan COD Anda Telah Diterima!</h1>
        <p class="mt-4 text-gray-600">Pesanan Anda dengan ID **#{{ $transaksi->id }}** akan segera kami siapkan. Mohon ambil pesanan Anda dan lakukan pembayaran tunai di toko kami.</p>

        <div class="mt-8 p-6 border rounded-lg text-left">
            <h3 class="text-lg font-semibold">Instruksi Pengambilan & Pembayaran</h3>
            <ul class="mt-4 space-y-2 text-gray-700 list-disc list-inside">
                <li>Total yang harus dibayar: <strong class="text-pink-500">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></li>
                <li>Silakan datang ke alamat kami di:</li>
            </ul>
            <address class="mt-2 p-4 bg-gray-50 rounded-md not-italic">
                <strong>Daara Bouquet</strong><br>
                Gedongan, Tlogoadi, Mlati, Sleman<br>
                Yogyakarta
            </address>
            <p class="mt-4 text-sm text-gray-500">Harap tunjukkan ID Pesanan Anda (#{{ $transaksi->id }}) kepada staf kami.</p>
        </div>

        <a href="{{ route('katalog.index') }}" class="mt-8 inline-block text-gray-600 hover:text-pink-500">
            &larr; Kembali Berbelanja
        </a>
    </div>
</div>
@endsection