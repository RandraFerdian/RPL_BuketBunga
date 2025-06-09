<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk: ') }} {{ $produk->nama_produk }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Menampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form action mengarah ke route 'produk.update' dengan method PUT --}}
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                </div>

                                <div class="mb-4">
                                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $produk->kategori) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                </div>

                                <div class="mb-4">
                                    <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                                    <select name="ukuran" id="ukuran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                        @foreach(['petite', 'small', 'medium', 'large', 'extra large', 'custom'] as $ukuran)
                                            <option value="{{ $ukuran }}" {{ old('ukuran', $produk->ukuran) == $ukuran ? 'selected' : '' }}>
                                                {{ ucfirst($ukuran) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                                    <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="gambar" class="block text-sm font-medium text-gray-700">Ganti Gambar Produk</label>
                                    <input type="file" name="gambar" id="gambar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah gambar.</p>
                                </div>
                                
                                @if ($produk->gambar)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="mt-2 w-32 h-32 object-cover rounded-md">
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('produk.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="ms-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>