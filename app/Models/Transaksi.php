<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Relasi ke User
use Illuminate\Database\Eloquent\Relations\HasMany; // Relasi ke DetailTransaksi

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'transaksi';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'id_user',
        'tanggal_transaksi',
        'total_harga',
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
}