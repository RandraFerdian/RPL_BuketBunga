<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('pesanan.index')" :active="request()->routeIs('pesanan.*')">
                                {{ __('Manajemen Pesanan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.*')">
                                {{ __('Manajemen Produk') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('katalog.index')" :active="request()->routeIs('katalog.index')">
                                {{ __('Katalog') }}
                            </x-nav-link>
                            {{-- REVISI: Menambahkan link Riwayat Pesanan dan Profil --}}
                            <x-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">
                                {{ __('Riwayat Pesanan') }}
                            </x-nav-link>
                            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('katalog.index')" :active="request()->routeIs('katalog.index')">
                            {{ __('Katalog') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-pink-500">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-pink-500 text-white rounded-full text-sm font-semibold hover:bg-pink-600 transition-colors">Daftar</a>
                    </div>
                @endauth
            </div>

            {{-- ... (kode hamburger tidak perlu diubah) ... --}}
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
             @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">{{ __('Admin Dashboard') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pesanan.index')" :active="request()->routeIs('pesanan.*')">{{ __('Manajemen Pesanan') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.*')">{{ __('Manajemen Produk') }}</x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('katalog.index')" :active="request()->routeIs('katalog.index')">{{ __('Katalog') }}</x-responsive-nav-link>
                    {{-- REVISI: Menambahkan link Riwayat dan Profil untuk Mobile --}}
                    <x-responsive-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">{{ __('Riwayat Pesanan') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">{{ __('Profil Saya') }}</x-responsive-nav-link>
                @endif
            @else
                 <x-responsive-nav-link :href="route('katalog.index')" :active="request()->routeIs('katalog.index')">{{ __('Katalog') }}</x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">{{ __('Login') }}</x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">{{ __('Daftar') }}</x-responsive-nav-link>
            @endauth
        </div>
        </div>
</nav>