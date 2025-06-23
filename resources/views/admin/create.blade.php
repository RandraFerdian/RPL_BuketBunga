<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    {{-- ====================================================== --}}
                    {{-- ==== BLOK PENTING UNTUK MENAMPILKAN ERROR ==== --}}
                    {{-- ====================================================== --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                            <p class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- ====================================================== --}}

                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            {{-- Kolom Kiri --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                </div>

                                <div>
                                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required placeholder="Contoh: SNACK BOUQUET">
                                </div>

                                <div>
                                    <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                                    <select name="ukuran" id="ukuran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                                        <option value="" disabled selected>Pilih Ukuran</option>
                                        <option value="petite" {{ old('ukuran') == 'petite' ? 'selected' : '' }}>Petite</option>
                                        <option value="small" {{ old('ukuran') == 'small' ? 'selected' : '' }}>Small</option>
                                        <option value="medium" {{ old('ukuran') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="large" {{ old('ukuran') == 'large' ? 'selected' : '' }}>Large</option>
                                        <option value="extra large" {{ old('ukuran') == 'extra large' ? 'selected' : '' }}>Extra Large</option>
                                        <option value="custom" {{ old('ukuran') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                    <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required placeholder="Contoh: 15000">
                                </div>

                                <div>
                                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Stok Awal</label>
                                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required placeholder="Jumlah stok yang tersedia">
                                </div>
                            </div>
                            
                            {{-- Input yang lebarnya penuh --}}
                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Jelaskan detail produk di sini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                                <input type="file" name="gambar" id="gambar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.produk.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-pink-500 text-white font-semibold rounded-md hover:bg-pink-600 shadow-md">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>