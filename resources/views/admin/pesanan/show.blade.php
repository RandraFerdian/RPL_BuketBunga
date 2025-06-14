@extends('layouts.app') 
@section('title', 'Detail Pesanan #' . $transaksi->id)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan #{{ $transaksi->id }}</h1>
        <a href="{{ route('admin.pesanan.index') }}" class="text-pink-600 hover:text-pink-800">&larr; Kembali ke Daftar Pesanan</a>
    </div>

    {{-- Menampilkan notifikasi sukses setelah update --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 my-6 rounded-md shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Detail Informasi Pesanan --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-md space-y-6">
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4">Informasi Pelanggan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><strong>Nama:</strong> {{ $transaksi->user->name ?? 'Pelanggan Dihapus' }}</p>
                    <p><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</p>
                    <p class="md:col-span-2"><strong>Alamat Pengiriman:</strong><br>{{ $transaksi->alamat_pengiriman }}</p>
                </div>
            </div>
            
            <div class="border-t pt-6">
                <h2 class="text-xl font-semibold border-b pb-2 mb-4">Detail Barang Pesanan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-2 px-3">Produk</th>
                                <th class="text-center py-2 px-3">Jumlah</th>
                                <th class="text-right py-2 px-3">Harga Satuan</th>
                                <th class="text-right py-2 px-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->detailTransaksi as $detail)
                            <tr class="border-b">
                                <td class="py-3 px-3">{{ $detail->produk->nama_produk }}</td>
                                <td class="text-center py-3 px-3">{{ $detail->jumlah }}</td>
                                <td class="text-right py-3 px-3">Rp{{ number_format($detail->harga_saat_transaksi) }}</td>
                                <td class="text-right py-3 px-3">Rp{{ number_format($detail->jumlah * $detail->harga_saat_transaksi) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-bold">
                                <td colspan="3" class="text-right py-3 px-3 border-t-2">Total</td>
                                <td class="text-right py-3 px-3 text-lg border-t-2">Rp{{ number_format($transaksi->total_harga) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form untuk Update Status --}}
        <div class="bg-white p-8 rounded-lg shadow-md self-start">
            <h2 class="text-xl font-semibold border-b pb-2 mb-4">Update Status</h2>
            
            {{-- Form ini sekarang mengarah ke route yang benar dan menggunakan method PUT --}}
            <form action="{{ route('admin.pesanan.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select id="status_pembayaran" name="status_pembayaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            <option value="belum lunas" {{ $transaksi->status_pembayaran == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <div>
                        <label for="status_konfirmasi" class="block text-sm font-medium text-gray-700">Status Pesanan</label>
                        <select id="status_konfirmasi" name="status_konfirmasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            <option value="menunggu" {{ $transaksi->status_konfirmasi == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $transaksi->status_konfirmasi == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $transaksi->status_konfirmasi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $transaksi->status_konfirmasi == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full px-4 py-3 bg-pink-600 text-white font-bold rounded-lg hover:bg-pink-700 transition-colors shadow-md">
                        Update Status
                    </button>
                </div>
            </form>

            {{-- Opsi untuk Menghapus Pesanan --}}
            <div class="border-t mt-6 pt-6">
                <form action="{{ route('admin.pesanan.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini secara permanen? Stok akan dikembalikan jika pesanan belum selesai.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-sm text-red-600 hover:text-red-800 hover:underline">
                        Hapus Pesanan Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection