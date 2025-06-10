<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model // <-- PASTIKAN NAMA CLASS-NYA BENAR
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'kategori',
        'ukuran',
        'harga',
        'deskripsi',
        'gambar',
    ];

     public function stok()
    {
        // Parameter kedua ('id_produk') adalah foreign key di tabel 'stok'
        return $this->hasOne(Stok::class, 'id_produk');
    }
}