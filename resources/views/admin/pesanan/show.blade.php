<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $transaksi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-bold">Detail Produk</h3>
                    <p class="text-sm text-gray-600 mb-4">Belum ada detail produk yang tersimpan.</p>
                    {{-- Nanti kita tampilkan daftar produk di sini --}}

                    <h3 class="text-lg font-bold mt-6">Detail Pelanggan</h3>
                    <p><strong>Nama:</strong> {{ $transaksi->user->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $transaksi->user->email ?? '-' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-bold">Status Pesanan</h3>
                    <form action="{{ route('pesanan.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>