<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukAdminController;

// Rute untuk Landing Page (welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute untuk Halaman Katalog (katalog.blade.php)
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

// Rute untuk Halaman Detail Produk (Wajib Login)
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show')->middleware('auth');

// Rute untuk dashboard pengguna biasa (dibuat oleh Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('katalog.index');
})->middleware(['auth'])->name('dashboard');

// Rute untuk profil pengguna (dibuat oleh Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk grup admin yang dilindungi
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/produk', ProdukAdminController::class);
});

// Rute untuk autentikasi (login, register, dll)
require __DIR__.'/auth.php';