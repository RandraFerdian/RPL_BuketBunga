<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - Daara Bouquet</title>
    {{-- Menggunakan CDN untuk styling Tailwind CSS agar cepat --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <h1 class="text-3xl font-bold text-pink-500">Daara Bouquet</h1>
            <p class="text-gray-600">for all your gift needs</p>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Katalog Produk Kami</h2>

        {{-- Grid untuk menampilkan produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            {{-- Looping untuk setiap produk yang dikirim dari Controller --}}
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    {{-- Bagian Gambar Produk --}}
                    <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                        {{-- Nantinya kita akan menampilkan gambar di sini --}}
                        <span class="text-gray-500">Gambar {{ $product->nama_produk }}</span>
                    </div>

                    {{-- Bagian Detail Produk --}}
                    <div class="p-4">
                        <p class="text-sm text-gray-500">{{ $product->kategori }}</p>
                        <h3 class="text-lg font-bold text-gray-900 truncate" title="{{ $product->nama_produk }}">
                            {{ $product->nama_produk }}
                        </h3>
                        <p class="mt-2 text-xl font-semibold text-pink-600">
                            Rp{{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                        <button class="mt-4 w-full bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600 transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </main>

</body>
</html>