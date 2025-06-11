<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Menggunakan variabel $pesanan --}}
            Detail Pesanan #{{ $pesanan->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.pesanan.index') }}" class="text-sm text-gray-600 hover:text-pink-500 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Detail Pelanggan</h3>
                        <div class="text-sm text-gray-600">
                            {{-- Menggunakan null-safe operator (?->) untuk keamanan --}}
                            <p><strong>Nama:</strong> {{ $pesanan->user?->name ?? 'Guest' }}</p>
                            <p><strong>Email:</strong> {{ $pesanan->user?->email ?? '-' }}</p>
                            <p><strong>Tanggal Pesan:</strong> {{ $pesanan->tanggal_transaksi ? \Carbon\Carbon::parse($pesanan->tanggal_transaksi)->format('d F Y, H:i') : '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Barang yang Dipesan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pesanan->detailTransaksi as $item)
                                        <tr>
                                            <td class="px-4 py-3 font-medium">{{ $item->produk?->nama_produk ?? 'Produk Dihapus' }}</td>
                                            <td class="px-4 py-3">{{ $item->jumlah }}</td>
                                            <td class="px-4 py-3">Rp{{ number_format($item->harga_satuan) }}</td>
                                            <td class="px-4 py-3 text-right">Rp{{ number_format($item->jumlah * $item->harga_satuan) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada detail produk.</td></tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-800">Total Pesanan</td>
                                        <td class="px-4 py-3 text-right font-bold text-gray-800">Rp{{ number_format($pesanan->total_harga) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg self-start">
                    <h3 class="text-lg font-bold mb-4">Status Pesanan</h3>
                    <form action="{{ route('admin.pesanan.update', $pesanan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="status_konfirmasi" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                            <select id="status_konfirmasi" name="status_konfirmasi" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="menunggu" @if($pesanan->status_konfirmasi == 'menunggu') selected @endif>Menunggu</option>
                                <option value="diproses" @if($pesanan->status_konfirmasi == 'diproses') selected @endif>Diproses</option>
                                <option value="selesai" @if($pesanan->status_konfirmasi == 'selesai') selected @endif>Selesai</option>
                                <option value="dibatalkan" @if($pesanan->status_konfirmasi == 'dibatalkan') selected @endif>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update Status</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>