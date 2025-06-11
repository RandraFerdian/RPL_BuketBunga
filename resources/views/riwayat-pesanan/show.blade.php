@extends('layouts.app')
@section('title', 'Detail Pesanan #'. $transaksi->id .' - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-playfair font-bold text-center mb-4">Detail Pesanan Anda</h1>
        <p class="text-center text-gray-500 text-lg mb-10">Pesanan #{{ $transaksi->id }}</p>

        <div class="bg-gray-50 p-8 rounded-lg shadow-sm max-w-4xl mx-auto space-y-8">
            {{-- Detail Pengiriman & Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-3">Detail Pengiriman</h3>
                    <p><strong>Nama Penerima:</strong> {{ $transaksi->user->name }}</p>
                    <p><strong>Alamat:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                    <p><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-3">Status</h3>
                    <p><strong>Status Pembayaran:</strong> 
                        <span class="font-bold {{ $transaksi->status_pembayaran == 'lunas' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($transaksi->status_pembayaran) }}
                        </span>
                    </p>
                    <p><strong>Status Pesanan:</strong> 
                        <span class="font-bold text-blue-600">{{ ucfirst($transaksi->status_konfirmasi) }}</span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->metode_pembayaran) }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            {{-- Detail Produk Dipesan --}}
            <div>
                <h3 class="text-xl font-semibold mb-3">Produk yang Dipesan</h3>
                <div class="space-y-4">
                    @foreach($transaksi->produks as $produk)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium">{{ $produk->nama_produk }}</p>
                            <p class="text-sm text-gray-500">{{ $produk->pivot->jumlah }} x Rp{{ number_format($produk->pivot->harga_saat_transaksi) }}</p>
                        </div>
                        <p class="font-medium">Rp{{ number_format($produk->pivot->jumlah * $produk->pivot->harga_saat_transaksi) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <div class="flex justify-between font-bold text-xl">
                        <span>Total Pembayaran</span>
                        <span>Rp{{ number_format($transaksi->total_harga) }}</span>
                    </div>
                </div>
            </div>

             <div class="text-center pt-6">
                <a href="{{ route('order.history') }}" class="text-pink-600 hover:text-pink-900 font-semibold">&larr; Kembali ke Riwayat Pesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection