<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Transaksi;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     * Ini adalah "daftar putih" kolom yang aman untuk diisi saat membuat atau mengupdate user.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role', // Penting untuk membedakan admin dan pelanggan
    ];

    /**
     * Atribut yang harus disembunyikan saat diubah menjadi array atau JSON.
     * Ini untuk keamanan agar password tidak pernah bocor.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Otomatis mengenkripsi password saat disimpan
        ];
    }

    /**
     * Mendefinisikan relasi ke model Transaksi.
     * Nama method ini ("transaksi") adalah yang kita panggil di controller.
     * Relasi: Satu User bisa memiliki banyak Transaksi (One to Many).
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }
}