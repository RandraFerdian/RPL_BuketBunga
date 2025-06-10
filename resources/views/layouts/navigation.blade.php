<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('katalog.index')" :active="request()->routeIs('katalog.index')">
                        {{ __('Katalog') }}
                    </x-nav-link>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard*')">
                                {{ __('Admin') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">
                                {{ __('Riwayat Pesanan') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex items-center justify-center flex-1 px-12">
                <form action="{{ route('produk.search') }}" method="GET" class="w-full max-w-lg">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="query" class="w-full pl-10 pr-4 py-2 border rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Cari buket bunga...">
                    </div>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center space-x-5">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-pink-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @if(count(session('cart', [])) > 0)
                            <span class="absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-xs rounded-full flex items-center justify-center">{{ count(session('cart', [])) }}</span>
                        @endif
                    </a>

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-pink-500">
                                    {{-- REVISI: Menampilkan nama pengguna --}}
                                    <div>Hi, {{ Auth::user()->name }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">{{-- ... (form logout) --}}</form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-pink-500">Login</a>
                    @endauth
                </div>
            </div>
            </div>
    </div>
</nav>