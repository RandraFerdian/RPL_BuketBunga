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
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Detail Pengiriman</h3>
                    <p class="text-gray-600"><strong>Nama Penerima:</strong> {{ $transaksi->user->name }}</p>
                    <p class="text-gray-600"><strong>Alamat:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                    <p class="text-gray-600"><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Status</h3>
                    <div class="space-y-2">
                        <p class="text-gray-600">
                            <strong>Pembayaran:</strong>
                            {{-- [REVISI] Menggunakan komponen badge yang konsisten --}}
                            @if($transaksi->status_pembayaran == 'lunas')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Belum Lunas
                                </span>
                            @endif
                        </p>
                        <p class="text-gray-600">
                            <strong>Pesanan:</strong>
                            {{-- [REVISI] Menggunakan komponen badge yang konsisten --}}
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                @if($transaksi->status_konfirmasi == 'selesai') bg-green-100 text-green-800
                                @elseif($transaksi->status_konfirmasi == 'diproses') bg-blue-100 text-blue-800
                                @elseif($transaksi->status_konfirmasi == 'dibatalkan') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $transaksi->status_konfirmasi }}
                            </span>
                        </p>
                        <p class="text-gray-600"><strong>Metode:</strong> {{ ucfirst($transaksi->metode_pembayaran) }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            {{-- Detail Produk Dipesan --}}
            <div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Produk yang Dipesan</h3>
                <div class="space-y-4">
                    @foreach($transaksi->produks as $produk)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $produk->nama_produk }}</p>
                            <p class="text-sm text-gray-500">{{ $produk->pivot->jumlah }} x Rp{{ number_format($produk->pivot->harga_satuan) }}</p>
                        </div>
                        <p class="font-medium text-gray-800">Rp{{ number_format($produk->pivot->jumlah * $produk->pivot->harga_satuan) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <div class="flex justify-between font-bold text-xl text-gray-900">
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