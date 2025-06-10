<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PesananAdminController;
use App\Http\Controllers\ProdukAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendaftarkan semua rute untuk aplikasi web kita.
|
*/


//======================================================================
// RUTE PUBLIK
// Semua orang bisa mengakses ini tanpa perlu login.
//======================================================================

Route::get('/', [KatalogController::class, 'welcome'])->name('welcome');

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/kategori/{kategori}', [KatalogController::class, 'showByCategory'])->name('katalog.kategori');


//======================================================================
// RUTE KERANJANG BELANJA
// Fungsionalitas menambah, melihat, dan mengubah isi keranjang.
//======================================================================

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');


//======================================================================
// RUTE UNTUK PENGGUNA TERAUTENTIKASI (WAJIB LOGIN)
//======================================================================

Route::middleware('auth')->group(function () {
    // Halaman detail produk
    Route::get('/katalog/{produk}', [KatalogController::class, 'show'])->name('katalog.show');
    Route::get('/search', [KatalogController::class, 'search'])->name('produk.search');

    // Halaman profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Alur proses checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutPage'])->name('checkout.show');
    Route::post('/checkout/now', [CheckoutController::class, 'showCheckoutNowPage'])->name('checkout.now');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
    Route::get('/order/{transaksi}/confirmation', [CheckoutController::class, 'showConfirmationPage'])->name('order.confirmation');
    Route::get('/order/{transaksi}/cod-confirmation', [CheckoutController::class, 'showCodConfirmationPage'])->name('order.cod_confirmation');

    Route::get('/riwayat-pesanan', [OrderHistoryController::class, 'index'])->name('order.history');
    Route::get('/riwayat-pesanan/{transaksi}', [OrderHistoryController::class, 'show'])->name('order.show');

    // Rute dashboard pengguna biasa yang dialihkan
    Route::get('/dashboard', function () {
        return redirect()->route('katalog.index');
    })->name('dashboard');
});


//======================================================================
// RUTE KHUSUS ADMIN
// Semua rute di dalam grup ini wajib login sebagai admin.
//======================================================================

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Rute Manajemen Produk (CRUD)
    Route::resource('/admin/produk', ProdukAdminController::class)->names('produk');
    
    // Rute Manajemen Pesanan
    Route::get('/admin/pesanan', [PesananAdminController::class, 'index'])->name('pesanan.index');
    Route::get('/admin/pesanan/{transaksi}', [PesananAdminController::class, 'show'])->name('pesanan.show');
    Route::put('/admin/pesanan/{transaksi}', [PesananAdminController::class, 'update'])->name('pesanan.update');
});


//======================================================================
// File rute autentikasi dari Breeze (login, register, dll.)
//======================================================================
require __DIR__.'/auth.php';