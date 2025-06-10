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
// RUTE PUBLIK (Dapat diakses semua orang)
//======================================================================

Route::controller(KatalogController::class)->group(function () {
    Route::get('/', 'welcome')->name('welcome');
    Route::get('/katalog', 'index')->name('katalog.index');
    Route::get('/katalog/search', 'search')->name('katalog.search');
    Route::get('/kategori/{kategori}', 'showByCategory')->name('katalog.kategori');
});

Route::controller(CartController::class)->name('cart.')->prefix('keranjang')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/tambah', 'add')->name('add');
    Route::patch('/update/{rowId}', 'update')->name('update');
    Route::delete('/hapus/{rowId}', 'remove')->name('remove');
});

// --- Grup Checkout & Riwayat Pesanan ---
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'showCheckoutPage')->name('checkout.show');
    Route::post('/checkout/now', 'showCheckoutNowPage')->name('checkout.now'); // <-- TAMBAHKAN KEMBALI BARIS INI
    Route::post('/checkout/process', 'processOrder')->name('checkout.process');
    Route::get('/order/{transaksi}/confirmation', 'showConfirmationPage')->name('order.confirmation');
});


//======================================================================
// RUTE UNTUK PENGGUNA TERAUTENTIKASI (Wajib Login)
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
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'showCheckoutPage')->name('checkout.show');
        Route::post('/checkout/process', 'processOrder')->name('checkout.process');
        Route::get('/order/{transaksi}/confirmation', 'showConfirmationPage')->name('order.confirmation');
    });

    Route::controller(OrderHistoryController::class)->prefix('riwayat-pesanan')->name('order.')->group(function () {
        Route::get('/', 'index')->name('history');
        Route::get('/{transaksi}', 'show')->name('show');
    });

    // --- Pengalihan Dashboard Pengguna Biasa ---
    Route::get('/dashboard', fn() => redirect()->route('katalog.index'))->name('dashboard');
});


//======================================================================
// RUTE KHUSUS ADMIN (Wajib Login sebagai Admin)
//======================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Otomatis memberi nama: admin.produk.index, admin.produk.create, dst.
    Route::resource('produk', ProdukAdminController::class);

    // Otomatis memberi nama: admin.pesanan.index, admin.pesanan.show, dst.
    Route::resource('pesanan', PesananAdminController::class)->except(['create', 'store', 'edit']);
});


//======================================================================
// FILE RUTE AUTENTIKASI DARI BREEZE
//======================================================================
require __DIR__ . '/auth.php';