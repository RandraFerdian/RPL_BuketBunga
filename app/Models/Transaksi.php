<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Relasi ke User
use Illuminate\Database\Eloquent\Relations\HasMany; // Relasi ke DetailTransaksi

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_user',
        'tanggal_transaksi',
        'total_harga',
        'alamat_pengiriman',
        'metode_pembayaran',
        'status_pembayaran',
        'status_konfirmasi',
    ];

    /**
     * Mendefinisikan relasi "milik" ke model User.
     * Satu transaksi dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Mendefinisikan relasi "memiliki banyak" ke model DetailTransaksi.
     * Satu transaksi memiliki banyak detail barang.
     */
    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    public function produks()
    {
        // Relasi many-to-many ke Produk melalui tabel pivot 'detail_transaksi'
        // withPivot akan mengambil kolom tambahan dari tabel pivot
        return $this->belongsToMany(Produk::class, 'detail_transaksi', 'id_transaksi', 'id_produk')
            ->withPivot('jumlah', 'harga_saat_transaksi');
    }
}
