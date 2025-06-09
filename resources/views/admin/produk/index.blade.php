@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5 flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Produk
        </h2>
        <a href="{{ route('produk.create') }}" class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600">
            + Tambah Produk
        </a>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6">

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($produks as $produk)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $produk->nama_produk }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($produk->harga) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $produk->stok }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('produk.edit', $produk->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection