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
}