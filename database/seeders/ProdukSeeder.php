<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN BARIS INI

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan pengecekan foreign key sementara
        Schema::disableForeignKeyConstraints();

        // Mengosongkan tabel produk
        Produk::truncate();

        // Mengaktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        $products = [
            // Data dari Artificial Flowers Bouquet
            ['nama_produk' => 'Buket Bunga Artificial Merah', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'petite', 'harga' => 10000, 'gambar' => 'produk/artificial-1.jpg'],
            ['nama_produk' => 'Buket Bunga Artificial "LOVE"', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'petite', 'harga' => 15000, 'gambar' => 'produk/artificial-2.jpg'],
            ['nama_produk' => 'Buket Bunga Matahari Artificial', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'small', 'harga' => 25000, 'gambar' => 'produk/artificial-3.jpg'],
            ['nama_produk' => 'Buket Bunga Putih Elegan', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'small', 'harga' => 35000, 'gambar' => 'produk/artificial-4.jpg'],
            ['nama_produk' => 'Buket Bunga Medium Classy', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'medium', 'harga' => 80000, 'gambar' => 'produk/artificial-5.jpg'],
            ['nama_produk' => 'Buket Bunga Large Premium', 'kategori' => 'ARTIFICIAL FLOWERS BOUQUET', 'ukuran' => 'large', 'harga' => 150000, 'gambar' => 'produk/artificial-6.jpg'],
            
            // Data dari Pipe Flowers Bouquet
            ['nama_produk' => 'Buket Bunga Pipa Tulip Ungu', 'kategori' => 'PIPE FLOWERS BOUQUET', 'ukuran' => 'petite', 'harga' => 25000, 'gambar' => 'produk/pipe-1.jpg'],
            ['nama_produk' => 'Buket Bunga Pipa Biru Medium', 'kategori' => 'PIPE FLOWERS BOUQUET', 'ukuran' => 'medium', 'harga' => 65000, 'gambar' => 'produk/pipe-2.jpg'],
            
            // Data dari Bouquet Boneka
            ['nama_produk' => 'Buket Boneka Wisuda Hitam', 'kategori' => 'BOUQUET BONEKA', 'ukuran' => 'large', 'harga' => 125000, 'gambar' => 'produk/boneka-1.jpg'],
            ['nama_produk' => 'Buket Boneka & Mawar Merah', 'kategori' => 'BOUQUET BONEKA', 'ukuran' => 'large', 'harga' => 200000, 'gambar' => 'produk/boneka-2.jpg'],

            // Data dari Snack Bouquet
            ['nama_produk' => 'Buket Snack Pillows Biru', 'kategori' => 'SNACK BOUQUET', 'ukuran' => 'small', 'harga' => 25000, 'gambar' => 'produk/snack-1.jpg'],
            ['nama_produk' => 'Buket Snack Pinky', 'kategori' => 'SNACK BOUQUET', 'ukuran' => 'small', 'harga' => 30000, 'gambar' => 'produk/snack-2.jpg'],
            ['nama_produk' => 'Buket Snack Extra Large', 'kategori' => 'SNACK BOUQUET', 'ukuran' => 'extra large', 'harga' => 500000, 'gambar' => 'produk/snack-3.jpg'],

            // Data dari Butterfly Bouquet
            ['nama_produk' => 'Buket Kupu-kupu Biru', 'kategori' => 'BUTTERFLY BOUQUET', 'ukuran' => 'small', 'harga' => 20000, 'gambar' => 'produk/butterfly-1.jpg'],
            ['nama_produk' => 'Buket Kupu-kupu Pink', 'kategori' => 'BUTTERFLY BOUQUET', 'ukuran' => 'small', 'harga' => 35000, 'gambar' => 'produk/butterfly-2.jpg'],
        ];

        // Looping untuk memasukkan setiap produk ke dalam database
        foreach ($products as $product) {
            Produk::create($product);
        }
    }
}