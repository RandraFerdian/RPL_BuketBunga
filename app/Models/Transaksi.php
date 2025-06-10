<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit (opsional jika nama model = nama tabel)
    protected $table = 'transaksi';

    // Mendefinisikan kolom yang boleh diisi secara massal
    protected $fillable = [
        'id_user',
        'tanggal_transaksi',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'status_konfirmasi',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Artinya, satu transaksi dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}