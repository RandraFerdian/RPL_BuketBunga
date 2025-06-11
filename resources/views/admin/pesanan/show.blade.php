@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $transaksi->id }}
        </h2>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6">
        
        {{-- Tombol Kembali (diambil dari branch 'main' dan diletakkan di atas) --}}
        <div class="mb-6">
            <a href="{{ route('admin.pesanan.index') }}" class="text-sm text-gray-600 hover:text-pink-500 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md" role="alert">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri - Detail Pesanan & Produk --}}
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-bold border-b pb-2 mb-3">Detail Pelanggan</h3>
                    <p><strong>Nama:</strong> {{ $transaksi->user->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</p>
                    <p><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
                    <p><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at ? $transaksi->created_at->format('d F Y, H:i') : 'Tanggal tidak tersedia' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold border-b pb-2 mb-3">Detail Produk Dipesan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mt-2">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transaksi->produks as $produk)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $produk->nama_produk }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $produk->pivot->jumlah }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right">Rp{{ number_format($produk->pivot->harga_saat_transaksi) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">Detail produk tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan - Status & Aksi --}}
            <div class="bg-gray-50 p-6 rounded-lg self-start space-y-6">
                <div>
                    <h3 class="text-lg font-bold mb-4">Update Status Pesanan</h3>
                    <form action="{{ route('admin.pesanan.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="status_konfirmasi" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                            <select name="status_konfirmasi" id="status_konfirmasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="menunggu" @if($transaksi->status_konfirmasi == 'menunggu') selected @endif>Menunggu</option>
                                <option value="diproses" @if($transaksi->status_konfirmasi == 'diproses') selected @endif>Diproses</option>
                                <option value="selesai" @if($transaksi->status_konfirmasi == 'selesai') selected @endif>Selesai</option>
                                <option value="dibatalkan" @if($transaksi->status_konfirmasi == 'dibatalkan') selected @endif>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update Status</button>
                    </form>
                </div>

                <div class="border-t border-gray-200"></div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Update Status Pembayaran</h3>
                    <form action="{{ route('admin.pesanan.updatePayment', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="belum lunas" {{ $transaksi->status_pembayaran == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                        <button type="submit" class="mt-4 w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">Update Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection