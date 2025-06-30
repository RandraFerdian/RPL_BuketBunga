@extends('layouts.app')
@section('content')
<header class="bg-white shadow-sm"><div class="container mx-auto px-6 py-5"><h2 class="font-semibold text-xl">Edit Kategori: {{ $kategori->nama_kategori }}</h2></div></header>
<div class="py-12">
    <div class="container mx-auto px-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('nama_kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.kategori.index') }}" class="text-gray-600 mr-4">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection