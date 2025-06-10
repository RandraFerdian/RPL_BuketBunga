<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-6">Daftar Transaksi Anda</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pesanan</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($order->tanggal_transaksi)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{-- KODE INI YANG MENAMPILKAN STATUS DENGAN WARNA --}}
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                                @if($order->status_konfirmasi == 'selesai') bg-green-100 text-green-800 
                                                @elseif($order->status_konfirmasi == 'diproses') bg-yellow-100 text-yellow-800 
                                                @elseif($order->status_konfirmasi == 'dibatalkan') bg-gray-200 text-gray-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($order->status_konfirmasi) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('order.show', $order) }}" class="text-pink-600 hover:text-pink-900">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            Anda belum memiliki riwayat pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Menampilkan link paginasi jika ada lebih dari 10 pesanan --}}
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>