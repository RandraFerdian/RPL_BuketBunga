<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel.
     */
    public function up(): void
    {
        // Tabel Users untuk login dan hak akses
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['pelanggan', 'admin', 'pemilik'])->default('pelanggan'); // Sesuai SKPL
            $table->rememberToken();
            $table->timestamps(); // Kolom created_at dan updated_at
        });

        // Tabel Produk untuk menyimpan data buket
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // ID Barang
            $table->string('nama_produk', 100); // Nama Barang
            $table->string('kategori', 50); // Kategori
            $table->enum('ukuran', ['petite', 'small', 'medium', 'large', 'extra large', 'custom']);
            $table->integer('harga'); // Harga
            $table->text('deskripsi')->nullable(); // Deskripsi
            $table->string('gambar', 255)->nullable(); // Gambar
            $table->timestamps();
        });
        
        // Tabel Stok untuk manajemen inventaris
        Schema::create('stok', function (Blueprint $table) {
            $table->id(); // ID Pengecekan Stok
            $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade'); // ID Barang
            $table->integer('jumlah'); // Jumlah Stok Tersedia
            $table->enum('status_stok', ['Ada', 'Kosong'])->default('Ada'); // Status Stok
            $table->date('tanggal_cek'); // Tanggal Pengecekan
            $table->timestamps();
        });

        // Tabel Transaksi untuk mencatat pesanan pelanggan
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // ID Transaksi
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('set null'); // ID Pelanggan
            $table->date('tanggal_transaksi'); // Tanggal Transaksi
            $table->integer('total_harga'); // Total Harga
            $table->enum('metode_pembayaran', ['tunai', 'transfer']); // Metode Pembayaran
            $table->enum('status_pembayaran', ['belum lunas', 'lunas']); // Status Pembayaran
            $table->enum('status_konfirmasi', ['menunggu', 'diproses', 'selesai'])->default('menunggu'); // Status Konfirmasi
            $table->timestamps();
        });

        // Tabel Detail Transaksi untuk item dalam satu pesanan
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade'); // ID Barang
            $table->integer('jumlah'); // Jumlah Barang Dibeli
            $table->integer('harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi untuk menghapus tabel.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('stok');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('users');
    }
};
