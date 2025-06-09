<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Daara Bouquet</title>

    {{-- Mengimpor font yang sama dengan landing page --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased">

    <div class="relative min-h-screen bg-cover bg-center flex items-center justify-center p-4" style="background-image: url('https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black opacity-40"></div>

        <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
            <div x-show="loaded" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-y-10"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="relative z-10 w-full max-w-md p-8 space-y-4 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl">
                
                <div class="text-center">
                    <a href="{{ route('welcome') }}">
                        <h1 class="text-4xl font-playfair font-bold text-gray-800">Daara Bouquet</h1>
                    </a>
                    <h2 class="mt-2 text-xl text-gray-700">Buat Akun Baru</h2>
                    <p class="text-sm text-gray-500">Daftar untuk mulai berbelanja.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" x-data="{ processing: false }" @submit.prevent="processing = true; $el.submit()">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="text-gray-700 font-medium" />
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="username" value="Username" class="text-gray-700 font-medium" />
                        <x-text-input id="username" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="text" name="username" :value="old('username')" required />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" value="Email" class="text-gray-700 font-medium" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password" class="text-gray-700 font-medium" />
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-medium" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                :disabled="processing"
                                :class="{ 'opacity-50 cursor-not-allowed': processing }"
                                class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300">
                            <span x-show="!processing">Daftar</span>
                            <span x-show="processing">Memproses...</span>
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-pink-600 hover:text-pink-500 hover:underline">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>