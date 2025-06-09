<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - Daara Bouquet</title>
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
                <h2 class="text-2xl font-playfair font-bold text-gray-800">Konfirmasi Password</h2>
                <p class="mt-2 text-sm text-gray-600">Ini adalah area aman aplikasi. Mohon konfirmasi password Anda sebelum melanjutkan.</p>
            </div>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div>
                    <x-input-label for="password" value="Password" class="text-gray-700 font-medium" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-50" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex justify-end mt-4">
                    <x-primary-button class="ms-4 !bg-pink-500 hover:!bg-pink-600">
                        {{ __('Konfirmasi') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>