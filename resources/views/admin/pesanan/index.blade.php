<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-semibold mb-6">Daftar Semua Pesanan</h3>
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
                                @forelse ($pesanan as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                        {{-- REVISI: Menggunakan null-safe operator (?->) untuk keamanan --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->user?->name ?? 'Guest' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{-- REVISI: Pengecekan keamanan jika tanggal null --}}
                                            {{ $order->tanggal_transaksi ? \Carbon\Carbon::parse($order->tanggal_transaksi)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($order->total_harga ?? 0) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($order->status_konfirmasi == 'selesai') bg-green-100 text-green-800 
                                                @elseif($order->status_konfirmasi == 'diproses') bg-yellow-100 text-yellow-800 
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($order->status_konfirmasi) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.pesanan.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada pesanan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $pesanan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>