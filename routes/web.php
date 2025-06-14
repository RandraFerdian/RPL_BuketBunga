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
|
| File rute ini telah direvisi untuk meningkatkan keterbacaan, konsistensi,
| dan sinkronisasi dengan controller yang telah diperbarui.
|
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

Route::controller(CartController::class)->prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/tambah', 'add')->name('add');
    Route::patch('/update/{rowId}', 'update')->name('update');
    Route::delete('/hapus/{id}', 'remove')->name('remove');
});


//======================================================================
// RUTE UNTUK PENGGUNA TERAUTENTIKASI (Wajib Login)
//======================================================================

Route::middleware('auth')->group(function () {
    
    // Rute dashboard utama untuk pengguna biasa
    Route::get('/dashboard', fn() => redirect()->route('katalog.index'))->name('dashboard');

    // Rute detail produk (memerlukan login untuk melihat detail)
    Route::get('/katalog/{produk}', [KatalogController::class, 'show'])->name('katalog.show');

    // Grup Profil Pengguna
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    // Grup Proses Checkout dan Konfirmasi
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'showCheckoutPage')->name('checkout.show');
        Route::post('/checkout/now', 'showCheckoutNowPage')->name('checkout.now');
        Route::post('/checkout/process', 'processOrder')->name('checkout.process');
        Route::get('/order/{transaksi}/confirmation', 'showConfirmationPage')->name('order.confirmation');
        Route::get('/order/{transaksi}/cod-confirmation', 'showCodConfirmationPage')->name('order.cod_confirmation');
    });

    // Grup Riwayat Pesanan Pengguna
    Route::controller(OrderHistoryController::class)->prefix('riwayat-pesanan')->name('order.')->group(function () {
        Route::get('/', 'index')->name('history');
        Route::get('/{transaksi}', 'show')->name('show');
    });

});


//======================================================================
// RUTE KHUSUS ADMIN (Wajib Login sebagai Admin)
//======================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen Produk (CRUD)
    Route::resource('produk', ProdukAdminController::class);

    // Manajemen Pesanan (CRUD)
    // Rute custom untuk update status pembayaran telah dihapus karena fungsinya
    // sudah diintegrasikan ke dalam method 'update' di PesananAdminController.
    Route::resource('pesanan', PesananAdminController::class)
        ->parameters(['pesanan' => 'transaksi'])
        ->except(['create', 'store', 'edit']);

});


//======================================================================
// FILE RUTE AUTENTIKASI DARI LARAVEL BREEZE
//======================================================================
require __DIR__ . '/auth.php';