@extends('layouts.app')

@section('content')
{{-- Header Halaman --}}
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </div>
</header>

{{-- Konten Utama --}}
<div class="py-12">
    <div class="container mx-auto px-6 space-y-8">

        {{-- Form untuk Update Informasi Profil --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Informasi Profil</h3>
                <p class="text-sm text-gray-600 mb-4">Perbarui informasi profil dan alamat email akun Anda.</p>
                
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name', $user->name) }}" required autofocus>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form untuk Update Password --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Update Password</h3>
                <p class="text-sm text-gray-600 mb-4">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
                
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="px-5 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form untuk Hapus Akun --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4 text-red-600">Hapus Akun</h3>
                <p class="text-sm text-gray-600 mb-4">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                     <div class="flex items-center justify-start">
                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus akun Anda secara permanen?')">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection