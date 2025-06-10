<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $transaksi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('order.history') }}" class="text-sm text-gray-600 hover:text-pink-500 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Riwayat Pesanan
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="border-b pb-6 mb-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">ID Pesanan</p>
                                <p class="font-semibold">#{{ $transaksi->id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tanggal</p>
                                <p class="font-semibold">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Metode Pembayaran</p>
                                <p class="font-semibold">{{ strtoupper($transaksi->metode_pembayaran) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Status</p>
                                <p>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($transaksi->status_konfirmasi == 'selesai') bg-green-100 text-green-800 
                                        @elseif($transaksi->status_konfirmasi == 'diproses') bg-yellow-100 text-yellow-800 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($transaksi->status_konfirmasi) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Rincian Barang</h3>
                    <div class="space-y-4">
                        @forelse ($transaksi->detailTransaksi as $item)
                            <div class="flex items-center justify-between p-4 border rounded-md">
                                <div class="flex items-center">
                                    <img src="{{ $item->produk->gambar ? asset('storage/' . $item->produk->gambar) : 'https://via.placeholder.com/100' }}" alt="{{ $item->produk->nama_produk }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->produk->nama_produk }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->jumlah }} x Rp{{ number_format($item->harga_satuan) }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-gray-800">Rp{{ number_format($item->jumlah * $item->harga_satuan) }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Detail barang tidak ditemukan.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 pt-6 border-t flex justify-end">
                        <div class="w-full max-w-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">Rp{{ number_format($transaksi->total_harga) }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg mt-2">
                                <span>Total</span>
                                <span class="text-pink-600">Rp{{ number_format($transaksi->total_harga) }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>