<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daara Bouquet</title>

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
                
                <div class="flex justify-center">
                    <a href="{{ route('welcome') }}">
                        <h1 class="text-4xl font-playfair font-bold text-gray-800">Daara Bouquet</h1>
                    </a>
                </div>
                
                <div class="text-center">
                    <h2 class="mt-2 text-xl text-gray-700">Selamat Datang Kembali</h2>
                    <p class="text-sm text-gray-500">Silakan masuk untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" x-data="{ processing: false }" @submit.prevent="processing = true; $el.submit()">
                    @csrf

                    <div>
                        {{-- PERUBAHAN 1: Menambahkan kelas text-gray-700 agar tulisan gelap --}}
                        <x-input-label for="email" value="Email" class="text-gray-700 font-medium" />
                        
                        {{-- PERUBAHAN 2: Menambahkan kelas bg-gray-50, border, dan text-gray-900 --}}
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-500 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        {{-- PERUBAHAN 1: Menambahkan kelas text-gray-700 agar tulisan gelap --}}
                        <x-input-label for="password" value="Password" class="text-gray-700 font-medium" />
                        
                        {{-- PERUBAHAN 2: Menambahkan kelas bg-gray-50, border, dan text-gray-900 --}}
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-500 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                :disabled="processing"
                                :class="{ 'opacity-50 cursor-not-allowed': processing }"
                                class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300">
                            
                            <svg x-show="processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            
                            <span x-show="!processing">Log in</span>
                            <span x-show="processing">Memproses...</span>
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-medium text-pink-600 hover:text-pink-500 hover:underline">Daftar di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>