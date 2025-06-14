<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            // Menambahkan kembali kolom harga_satuan setelah kolom 'jumlah'
            $table->integer('harga_satuan')->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
        });
    }
};