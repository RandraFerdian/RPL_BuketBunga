@extends('layouts.app')

@section('content')

{{-- Header Halaman --}}
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $transaksi->id }}
        </h2>
    </div>
</header>

{{-- Konten Utama --}}
<div class="py-12">
    <div class="container mx-auto px-6">
        
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
                    <p><strong>Tanggal Pesan:</strong> {{ $transaksi->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold border-b pb-2 mb-3">Detail Produk</h3>
                    {{-- Logika untuk menampilkan detail produk akan kita tambahkan nanti --}}
                    <p class="text-sm text-gray-600">Belum ada detail produk yang tersimpan.</p>
                </div>
            </div>

            {{-- Kolom Kanan - Status & Aksi --}}
            <div class="bg-gray-50 p-6 rounded-lg self-start">
                <h3 class="text-lg font-bold mb-4">Status Pesanan</h3>

                <form action="{{ route('admin.pesanan.update', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="status_konfirmasi" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                        <select id="status_konfirmasi" name="status_konfirmasi" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="menunggu" @if($transaksi->status_konfirmasi == 'menunggu') selected @endif>Menunggu</option>
                            <option value="diproses" @if($transaksi->status_konfirmasi == 'diproses') selected @endif>Diproses</option>
                            <option value="selesai" @if($transaksi->status_konfirmasi == 'selesai') selected @endif>Selesai</option>
                            <option value="dibatalkan" @if($transaksi->status_konfirmasi == 'dibatalkan') selected @endif>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update Status</button>
                </form>
                
                <a href="{{ route('admin.pesanan.index') }}" class="inline-block mt-6 text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection