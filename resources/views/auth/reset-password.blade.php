<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Daara Bouquet</title>
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
        <div class="relative z-10 w-full max-w-md p-8 space-y-4 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl">
            <div class="text-center">
                <h2 class="text-2xl font-playfair font-bold text-gray-800">Atur Ulang Password</h2>
                <p class="mt-2 text-sm text-gray-600">Buat password baru untuk akun Anda.</p>
            </div>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div>
                    <x-input-label for="email" value="Email" class="text-gray-700 font-medium" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="password" value="Password Baru" class="text-gray-700 font-medium" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" class="text-gray-700 font-medium" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-300 text-gray-900" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-primary-button class="w-full justify-center text-base !bg-pink-500 hover:!bg-pink-600">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>