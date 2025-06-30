@extends('layouts.app')
@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5 flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Kategori</h2>
        <a href="{{ route('admin.kategori.create') }}" class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600">+ Tambah Kategori</a>
    </div>
</header>
<div class="py-12">
    <div class="container mx-auto px-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert"><p>{{ session('success') }}</p></div>
        @endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $kategori->nama_kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="inline-block ml-4">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-6 py-4 text-center">Belum ada kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6">{{ $kategoris->links() }}</div>
        </div>
    </div>
</div>
@endsection