<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <p class="text-2xl font-bold">{{ $totalProduk }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5-15h16.5" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <p class="text-2xl font-bold">{{ $totalPesanan }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.825-1.106-2.295 0-3.121C10.442 7.219 11.25 7 12 7c.75 0 1.45.22 2.003.659" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-4 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.305l-2.625-3.375-4.121 2.305m0 0a9.007 9.007 0 0 1-2.625.372M3 19.128a9.38 9.38 0 0 1 2.625-.372 9.337 9.337 0 0 1 4.121 2.305l-2.625 3.375-4.121-2.305M15 19.128V14.673a9.003 9.003 0 0 0-2.625-.372m-2.625.372a9.003 9.003 0 0 0-2.625.372V19.128" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Pelanggan</p>
                        <p class="text-2xl font-bold">{{ $totalPelanggan }}</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                        <div class="space-y-4">
                            <a href="{{ route('produk.create') }}" class="block w-full text-center px-4 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">Tambah Produk Baru</a>
                            <a href="{{ route('produk.index') }}" class="block w-full text-center px-4 py-3 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Lihat Semua Produk</a>
                            {{-- Tambahkan link ke manajemen pesanan jika sudah dibuat --}}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Pesanan Terbaru</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($pesananTerbaru as $pesanan)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">{{ $pesanan->user->name ?? 'Guest' }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap">Rp{{ number_format($pesanan->total_harga) }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($pesanan->status_konfirmasi == 'selesai') bg-green-100 text-green-800 @endif
                                                        @if($pesanan->status_konfirmasi == 'diproses') bg-yellow-100 text-yellow-800 @endif
                                                        @if($pesanan->status_konfirmasi == 'menunggu') bg-red-100 text-red-800 @endif">
                                                        {{ ucfirst($pesanan->status_konfirmasi) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-3 text-center text-gray-500">Belum ada pesanan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>