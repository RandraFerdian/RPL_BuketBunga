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
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="text-2xl font-playfair font-bold text-gray-800">Daara Bouquet</a>
            <div class="flex items-center space-x-6">
                <a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-pink-500">Katalog</a>

                @auth
                    {{-- Jika pengguna sudah login --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-pink-500">Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="text-gray-600 hover:text-pink-500">
                            Logout
                        </a>
                    </form>
                @else
                    {{-- Jika pengguna adalah tamu (belum login) --}}
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">
                        Login
                    </a>
                @endauth
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