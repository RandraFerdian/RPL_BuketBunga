<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok'; // Memberitahu Laravel nama tabelnya adalah 'stok'

    protected $fillable = [
        'id_produk',
        'jumlah',
        'status_stok',
    ];

    /**
     * Mendefinisikan relasi ke model Produk.
     * Satu data stok dimiliki oleh satu produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}