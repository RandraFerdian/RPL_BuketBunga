@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- PERBAIKAN: Gunakan variabel $pesanans yang dikirim dari controller --}}
                            @forelse ($pesanans as $order)
                                <tr>
                                    <td class="px-6 py-4">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                                    {{-- Kolom tanggal_transaksi tidak ada di controller Anda, kita gunakan created_at --}}
                                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">Rp{{ number_format($order->total_harga) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($order->status_konfirmasi == 'selesai') bg-green-100 text-green-800 
                                            @elseif($order->status_konfirmasi == 'diproses') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->status_konfirmasi) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('pesanan.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center">Tidak ada pesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- PERBAIKAN: Gunakan variabel $pesanans untuk pagination links --}}
                <div class="mt-4">
                    {{ $pesanans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection