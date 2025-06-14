@extends('layouts.app')
@section('title', 'Selesaikan Pembayaran Pesanan #'. $transaksi->id)

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-6 max-w-2xl text-center">
        
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-md" role="alert">
            <p class="font-bold">Pesanan Anda Berhasil Dibuat!</p>
            <p>Pesanan Anda dengan ID #{{ $transaksi->id }} telah kami terima. Mohon selesaikan pembayaran untuk kami proses lebih lanjut.</p>
        </div>

        <h1 class="text-3xl font-playfair font-bold mb-4">Selesaikan Pembayaran</h1>
        <p class="text-gray-600 mb-8">Silakan lakukan transfer sejumlah total pembayaran ke salah satu rekening di bawah ini.</p>

        <div class="bg-gray-50 p-8 rounded-lg shadow-sm text-left space-y-6">
            <div>
                <p class="text-lg font-semibold">Total Pembayaran:</p>
                <p class="text-4xl font-bold text-pink-600">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">Pastikan Anda mentransfer dengan nominal yang sama persis untuk mempermudah verifikasi.</p>
            </div>
            
            <div class="border-t border-gray-200"></div>

            <div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Metode Pembayaran</h3>
                 <div class="space-y-4">
                    {{-- Opsi 1: QRIS (jika Anda punya gambar QRIS statis) --}}
                    <div>
                        <p class="font-bold mb-2">Scan QRIS (Semua E-Wallet & M-Banking)</p>
                        <div class="text-center">
                             {{-- Ganti 'images/qris-daara.png' dengan path gambar QRIS Anda di folder /public --}}
                             <img src="{{ asset('images/qris-daara.png') }}" alt="Scan QRIS untuk Pembayaran" class="mx-auto max-w-xs border p-2 rounded-lg shadow-sm">
                        </div>
                    </div>

                    {{-- Opsi 2: Transfer Bank Manual --}}
                    <div class="pt-4">
                        <p class="font-bold">Atau Transfer Manual ke:</p>
                        <p class="mt-2">Bank: <span class="font-mono font-semibold">BCA</span></p>
                        <p>Nomor Rekening: <span class="font-mono font-semibold">1234567890</span></p>
                        <p>Atas Nama: <span class="font-mono font-semibold">Daara Bouquet</span></p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            {{-- [REVISI] Instruksi konfirmasi yang lebih jelas --}}
            <div>
                 <h3 class="text-xl font-semibold mb-3 text-gray-800">Wajib Konfirmasi Setelah Transfer</h3>
                 <p class="text-gray-600">Setelah melakukan pembayaran, mohon lakukan konfirmasi melalui WhatsApp ke nomor <a href="https://wa.me/6282223289755?text=Halo%2C%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20pesanan%20ID%20%23{{ $transaksi->id }}" class="text-pink-600 font-bold hover:underline" target="_blank">0822-2328-9755</a> dengan mengirimkan:</p>
                 <ul class="list-disc list-inside mt-2 text-gray-600">
                    <li>ID Pesanan Anda: <strong>#{{ $transaksi->id }}</strong></li>
                    <li>Bukti transfer (screenshot/foto)</li>
                 </ul>
            </div>
        </div>

        <div class="mt-10">
            <a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-pink-900 font-semibold">&larr; Kembali Berbelanja</a>
        </div>

    </div>
</div>
@endsection