<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daara Bouquet - Kado Terindah untuk Momen Spesial</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="font-poppins bg-gray-50 text-gray-800">

    <nav class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="text-2xl font-playfair font-bold text-gray-800">Daara Bouquet</a>
            <div class="flex items-center space-x-6">
                <a href="#produk" class="hidden md:block text-gray-600 hover:text-pink-500">Produk</a>
                <a href="#tentang" class="hidden md:block text-gray-600 hover:text-pink-500">Tentang</a>
                <a href="{{ route('katalog.index') }}" class="px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">Katalog</a>
                <div class="flex items-center space-x-4">
                    @auth
                    {{-- Jika pengguna sudah login, tampilkan tombol Logout --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="px-5 py-2 bg-pink-100 text-pink-600 rounded-full text-sm font-semibold hover:bg-pink-200 transition-colors">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-gray-600 hover:text-pink-500">
                            Logout
                        </a>
                    </form>
                    @else
                    {{-- Jika belum login, tampilkan tombol Login dan Daftar --}}
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-pink-500 text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">
                        Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="relative min-h-[90vh] bg-cover bg-center flex items-center" style="background-image: url('https://images.unsplash.com/photo-1562690868-60336d15215C?q=80&w=1887&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-pink-600"></div>
        <div class="relative container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-playfair font-bold drop-shadow-lg">Ungkapkan Perasaan, Lewat Bunga</h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md">Kado terindah untuk setiap momen berharga dalam hidup Anda.</p>
            <a href="{{ route('katalog.index') }}" class="mt-8 inline-block px-10 py-4 bg-white text-pink-500 font-bold rounded-full text-lg hover:bg-gray-200 transition-colors shadow-lg">
                Jelajahi Koleksi Kami
            </a>
        </div>
    </header>

    <main>
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-playfair font-bold">Kenapa Memilih Kami?</h2>
                <p class="mt-2 text-gray-600">Kami memberikan yang terbaik untuk hari spesial Anda.</p>
                <div class="mt-12 grid md:grid-cols-3 gap-12">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center">
                            {{-- Ganti dengan Ikon SVG --}}
                            <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">Desain Kreatif</h3>
                        <p class="mt-2 text-gray-600">Setiap buket dirangkai dengan sentuhan personal dan kreativitas tanpa batas.</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">Proses Cepat</h3>
                        <p class="mt-2 text-gray-600">Pemesanan mudah dan proses pengerjaan yang cepat untuk memenuhi kebutuhan Anda.</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-bold">Kualitas Terjamin</h3>
                        <p class="mt-2 text-gray-600">Kami hanya menggunakan bunga dan material pilihan dengan kualitas terbaik.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="produk" class="py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-playfair font-bold">Koleksi Terfavorit</h2>
                <p class="mt-2 text-gray-600">Beberapa pilihan yang paling dicintai pelanggan kami.</p>

                {{-- Grid untuk menampilkan produk --}}
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                    {{-- Loop untuk setiap produk yang dikirim dari controller --}}
                    @forelse ($produks as $produk)
                    {{-- Setiap produk dibungkus dengan link ke halaman detailnya --}}
                    <a href="{{ route('katalog.show', $produk) }}" class="group block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden text-left">
                        <div class="overflow-hidden h-64">
                            {{-- Menampilkan gambar produk dari storage Anda --}}
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="p-5">
                            {{-- Menampilkan nama produk --}}
                            <h3 class="font-semibold text-lg text-gray-800 truncate" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h3>
                            {{-- Menampilkan harga --}}
                            <p class="text-pink-500 font-bold mt-2">Rp{{ number_format($produk->harga) }}</p>
                        </div>
                    </a>
                    @empty
                    {{-- Ini akan tampil jika tidak ada produk sama sekali di database --}}
                    <div class="lg:col-span-4 text-center text-gray-500">
                        <p>Belum ada produk favorit untuk ditampilkan.</p>
                    </div>
                    @endforelse

                </div>

                {{-- Tombol untuk melihat semua produk --}}
                <div class="mt-16">
                    <a href="{{ route('katalog.index') }}" class="px-8 py-3 border border-gray-800 text-gray-800 font-bold rounded-full text-base hover:bg-gray-800 hover:text-white transition-colors">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </section>
        <section id="tentang" class="py-20 bg-pink-50">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

                {{-- BAGIAN GAMBAR YANG DIPERBAIKI --}}
                <div>
                    <img src="{{ asset('images/tentang-kami.png') }}" class="rounded-lg shadow-xl" alt="Tentang Daara Bouquet">
                </div>

                {{-- BAGIAN TEKS DAN TOMBOL --}}
                <div>
                    <h2 class="text-4xl font-playfair font-bold">Cerita di Balik Daara Bouquet</h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Daara Bouquet lahir dari kecintaan kami terhadap keindahan dan seni merangkai bunga. Kami percaya bahwa setiap tangkai bunga memiliki cerita dan setiap buket adalah pesan yang tulus. Misi kami adalah membantu Anda menyampaikan pesan cinta, terima kasih, dan kebahagiaan melalui rangkaian bunga yang kami buat dengan sepenuh hati.
                    </p>
                    {{-- TOMBOL INI SUDAH BENAR, MENGARAH KE HALAMAN KATALOG --}}
                    <a href="{{ route('katalog.index') }}" class="mt-6 inline-block text-pink-500 font-semibold hover:underline">
                        Lihat Semua Cerita &rarr;
                    </a>
                </div>

            </div>
        </section>

        <section class="py-20 bg-white text-center">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-playfair font-bold">Siap Menemukan Kado Sempurna?</h2>
                <p class="mt-2 text-gray-600 max-w-xl mx-auto">Jelajahi katalog lengkap kami dan temukan rangkaian yang paling pas untuk mewakili perasaan Anda.</p>
                <a href="{{ route('katalog.index') }}" class="mt-8 inline-block px-10 py-4 bg-gray-800 text-white font-bold rounded-full text-lg hover:bg-gray-700 transition-colors shadow-lg">
                    Buka Katalog Lengkap
                </a>
            </div>
        </section>

    </main>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-8 text-center">
            <p>&copy; {{ date('Y') }} Daara Bouquet. Semua Hak Cipta Dilindungi.</p>
            <p class="text-sm text-gray-400 mt-2">Dibuat dengan ❤️ di Yogyakarta</p>
        </div>
    </footer>

</body>

</html>