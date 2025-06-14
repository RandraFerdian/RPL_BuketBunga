@extends('layouts.app')
@section('title', 'Riwayat Pesanan Saya - Daara Bouquet')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-playfair font-bold text-center mb-10">Riwayat Pesanan Saya</h1>

        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total</th>
                            {{-- [REVISI] Menambahkan kolom Status Pembayaran --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status Pesanan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">#{{ $transaksi->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->created_at->format('d F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($transaksi->total_harga) }}</td>
                                
                                {{-- [REVISI] Badge untuk Status Pembayaran --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaksi->status_pembayaran == 'lunas')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- [REVISI] Badge untuk Status Pesanan (dengan tambahan status 'dibatalkan') --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                        @if($transaksi->status_konfirmasi == 'selesai') bg-green-100 text-green-800
                                        @elseif($transaksi->status_konfirmasi == 'diproses') bg-blue-100 text-blue-800
                                        @elseif($transaksi->status_konfirmasi == 'dibatalkan') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $transaksi->status_konfirmasi }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('order.show', $transaksi->id) }}" class="text-pink-600 hover:text-pink-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- [REVISI] Colspan disesuaikan menjadi 6 --}}
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Anda belum memiliki riwayat pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination Links --}}
            <div class="mt-6">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection