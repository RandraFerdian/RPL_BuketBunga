<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\PesananAdminController;
use App\Http\Controllers\ProdukAdminController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//======================================================================
// RUTE PUBLIK
//======================================================================

// Mengelompokkan rute yang menggunakan KatalogController
Route::controller(KatalogController::class)->group(function () {
    Route::get('/', 'welcome')->name('welcome');
    Route::get('/katalog', 'index')->name('katalog.index');
    Route::get('/katalog/search', 'search')->name('produk.search');
    Route::get('/kategori/{kategori}', 'showByCategory')->name('katalog.kategori');
});

// Mengelompokkan rute yang menggunakan CartController
Route::controller(CartController::class)->name('cart.')->group(function () {
    Route::get('/keranjang', 'index')->name('index');
    Route::post('/keranjang/tambah', 'add')->name('add');
    Route::patch('/keranjang/update/{productId}', 'update')->name('update');
    Route::delete('/keranjang/hapus', 'remove')->name('remove');
});


//======================================================================
// RUTE UNTUK PENGGUNA TERAUTENTIKASI (WAJIB LOGIN)
//======================================================================

Route::middleware('auth')->group(function () {
    Route::get('/katalog/{produk}', [KatalogController::class, 'show'])->name('katalog.show');

    // --- Grup Profil ---
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // --- Grup Checkout & Riwayat Pesanan ---
    Route::controller(CheckoutController::class)->group(function() {
        Route::get('/checkout', 'showCheckoutPage')->name('checkout.show');
        Route::post('/checkout/now', 'showCheckoutNowPage')->name('checkout.now');
        Route::post('/checkout/process', 'processOrder')->name('checkout.process');
        Route::get('/order/{transaksi}/confirmation', 'showConfirmationPage')->name('order.confirmation');
        Route::get('/order/{transaksi}/cod-confirmation', 'showCodConfirmationPage')->name('order.cod_confirmation');
    });
    
    Route::controller(OrderHistoryController::class)->prefix('riwayat-pesanan')->name('order.')->group(function() {
        Route::get('/', 'index')->name('history');
        Route::get('/{transaksi}', 'show')->name('show');
    });

    // --- Pengalihan Dashboard Pengguna Biasa ---
    Route::get('/dashboard', fn() => redirect()->route('katalog.index'))->name('dashboard');
});


//======================================================================
// RUTE KHUSUS ADMIN (WAJIB LOGIN SEBAGAI ADMIN)
//======================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Resource untuk Produk, otomatis memberi nama 'admin.produk.index', 'admin.produk.create', dst.
    Route::resource('/produk', ProdukAdminController::class)->names('produk');
    
    // Rute Manajemen Pesanan
    Route::controller(PesananAdminController::class)->prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{transaksi}', 'show')->name('show');
        Route::put('/{transaksi}', 'update')->name('update');
    });
});


//======================================================================
// FILE RUTE AUTENTIKASI DARI BREEZE
//======================================================================
require __DIR__.'/auth.php';