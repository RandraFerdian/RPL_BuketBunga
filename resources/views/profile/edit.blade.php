@extends('layouts.app')

@section('content')
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </div>
</header>

<div class="py-12">
    <div class="container mx-auto px-6 space-y-8">

        {{-- Form untuk Update Informasi Profil --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                {{-- ======================================================== --}}
                {{-- ============ TAMBAHKAN BLOK NOTIFIKASI DI SINI ============ --}}
                {{-- ======================================================== --}}
                @if (session('status') === 'profile-updated')
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm" role="alert">
                    <p class="font-medium">Perubahan berhasil disimpan!</p>
                </div>
                @endif
                {{-- ======================================================== --}}

                <h3 class="text-lg font-semibold mb-4">Informasi Profil</h3>
                {{-- ... sisa form Anda ... --}}

                {{-- Form untuk Update Informasi Profil --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Informasi Profil</h3>
                        <p class="text-sm text-gray-600 mb-4">Perbarui informasi profil dan alamat email akun Anda.</p>

                        {{-- PERBAIKAN 1: method="post" dan @method('patch') --}}
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

                        {{-- ======================================================== --}}
                        {{-- ============ NOTIFIKASI SUKSES DITAMBAHKAN DI SINI ============ --}}
                        {{-- ======================================================== --}}
                        @if (session('status') === 'password-updated')
                        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm" role="alert">
                            <p class="font-medium">Password berhasil diperbarui!</p>
                        </div>
                        @endif

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input id="current_password" name="current_password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                {{-- Menampilkan error spesifik untuk field ini --}}
                                @error('current_password', 'updatePassword')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                {{-- Menampilkan error spesifik untuk field ini --}}
                                @error('password', 'updatePassword')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
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

                {{-- ========================================================== --}}
                {{-- ============ Form untuk Hapus Akun (Diperbaiki) ============ --}}
                {{-- ========================================================== --}}
                <div x-data="{ confirmingUserDeletion: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-red-600">Hapus Akun</h3>
                        <p class="text-sm text-gray-600 mb-4">Setelah akun Anda dihapus, semua datanya akan dihapus secara permanen. Harap pertimbangkan baik-baik sebelum melanjutkan.</p>

                        {{-- Tombol ini sekarang memicu pop-up, bukan langsung submit form --}}
                        <button @click="confirmingUserDeletion = true" class="px-5 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700">
                            Hapus Akun
                        </button>

                        {{-- ============================================= --}}
                        {{-- ============ Pop-up Konfirmasi ============ --}}
                        {{-- ============================================= --}}
                        <div x-show="confirmingUserDeletion"
                            x-trap.inert.noscroll="confirmingUserDeletion"
                            @keydown.escape.window="confirmingUserDeletion = false"
                            class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
                            style="display: none;">

                            <div @click="confirmingUserDeletion = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                            <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Apakah Anda yakin ingin menghapus akun Anda?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        Sekali lagi, semua data akan hilang selamanya. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                                    </p>

                                    <div class="mt-6">
                                        <label for="password" class="sr-only">Password</label>
                                        <input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="Password" required>
                                        @error('password', 'userDeletion')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button type="button" @click="confirmingUserDeletion = false" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                            Batal
                                        </button>
                                        <button type="submit" class="ms-3 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            Hapus Akun Permanen
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endsection