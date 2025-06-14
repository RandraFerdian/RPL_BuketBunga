<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Mengubah nama kolom dari 'harga_saat_transaksi' menjadi 'harga_satuan'
            $table->renameColumn('harga_saat_transaksi', 'harga_satuan');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Jika migrasi dibatalkan, kembalikan namanya seperti semula
            $table->renameColumn('harga_satuan', 'harga_saat_transaksi');
        });
    }
};