<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Daara Bouquet' }}</title>
    
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    
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

    <nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-sm sticky top-0 z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <div class="shrink-0">
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-3">
                            <span class="self-center text-2xl font-playfair font-semibold whitespace-nowrap">Daara Bouquet</span>
                        </a>
                    </div>
                    
                    <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard*') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Dashboard</a>
                                <a href="{{ route('admin.pesanan.index') }}" class="{{ request()->routeIs('admin.pesanan.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Pesanan</a>
                                <a href="{{ route('admin.produk.index') }}" class="{{ request()->routeIs('admin.produk.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Produk</a>
                            @else
                                <a href="{{ route('katalog.index') }}" class="{{ request()->routeIs('katalog.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Katalog</a>
                                <a href="{{ route('order.history') }}" class="{{ request()->routeIs('order.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Riwayat Pesanan</a>
                            @endif
                        @else
                            <a href="{{ route('katalog.index') }}" class="{{ request()->routeIs('katalog.index') ? 'bg-pink-500 text-white shadow-sm' : 'text-gray-600 hover:text-pink-500' }} px-4 py-2 rounded-full text-sm font-medium transition-colors">Katalog</a>
                        @endauth
                    </div>
                </div>

                <div class="hidden sm:flex items-center space-x-5">
                    <form action="{{ route('produk.search') }}" method="GET" class="w-full max-w-xs">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="search" name="query" class="w-full pl-10 pr-4 py-2 border rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-sm" placeholder="Cari buket..." value="{{ request('query') ?? '' }}">
                        </div>
                    </form>

                    <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-pink-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @if(count(session('cart', [])) > 0)
                            <span class="absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-xs rounded-full flex items-center justify-center">{{ count(session('cart', [])) }}</span>
                        @endif
                    </a>

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-pink-500 focus:outline-none">
                                    <div>Hi, {{ Auth::user()->name }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link></form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">Login</a>
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
        </div>
    </footer>
</body>
</html>