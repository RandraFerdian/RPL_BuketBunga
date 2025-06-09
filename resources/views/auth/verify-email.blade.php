<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Daara Bouquet</title>
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
        <div class="relative z-10 w-full max-w-lg p-8 text-center bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl">
            <h2 class="text-2xl font-playfair font-bold text-gray-800">Satu Langkah Lagi!</h2>
            <div class="my-4 text-sm text-gray-600">
                <p>Terima kasih telah mendaftar! Sebelum melanjutkan, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan?</p>
                <p class="mt-2">Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkannya lagi.</p>
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Sebuah link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif
            <div class="mt-6 flex items-center justify-center space-x-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="!bg-pink-500 hover:!bg-pink-600">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-primary-button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Daara Bouquet</title>
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
        <div class="relative z-10 w-full max-w-lg p-8 text-center bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl">
            <h2 class="text-2xl font-playfair font-bold text-gray-800">Satu Langkah Lagi!</h2>
            <div class="my-4 text-sm text-gray-600">
                <p>Terima kasih telah mendaftar! Sebelum melanjutkan, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan?</p>
                <p class="mt-2">Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkannya lagi.</p>
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Sebuah link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif
            <div class="mt-6 flex items-center justify-center space-x-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="!bg-pink-500 hover:!bg-pink-600">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-primary-button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>