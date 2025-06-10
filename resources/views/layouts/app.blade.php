<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis, dengan judul default 'Daara Bouquet' --}}
    <title>{{ $title ?? 'Daara Bouquet' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="font-poppins bg-gray-50 text-gray-800">

    <nav class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('welcome') }}" class="text-2xl font-playfair font-bold text-gray-800">Daara Bouquet</a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-pink-500 transition-colors">Katalog</a>

                    @auth
                        {{-- Menu untuk pengguna yang sudah login --}}
                        @if(Auth::user()->role === 'admin')
                            {{-- Menu Khusus Admin --}}
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-pink-500 transition-colors">Dashboard</a>
                            <a href="{{ route('pesanan.index') }}" class="text-gray-600 hover:text-pink-500 transition-colors">Pesanan</a>
                            <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-pink-500 transition-colors">Produk</a>
                        @else
                            {{-- Menu Khusus Pengguna Biasa --}}
                             <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-pink-500 transition-colors">Profil Saya</a>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Ikon Keranjang Belanja --}}
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-pink-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-xs rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        {{-- Tombol Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-pink-500 text-sm">Logout</button>
                        </form>
                    @else
                        {{-- Tombol Login untuk Tamu --}}
                        <a href="{{ route('login') }}" class="hidden sm:block px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-8 text-center">
            <p>&copy; {{ date('Y') }} Daara Bouquet. Semua Hak Cipta Dilindungi.</p>
            <p class="text-sm text-gray-400 mt-2">Dibuat dengan ❤️ di Yogyakarta</p>
        </div>
    </footer>

</body>
</html>