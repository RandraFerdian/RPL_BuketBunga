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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // ===============================================
    // ==== TAMBAHKAN METHOD INI DI DALAM CLASS ====
    // ===============================================
    /**
     * Mendefinisikan relasi ke model Transaksi.
     * Nama method ini ("transaksi") adalah yang kita panggil di controller.
     * Relasi: Satu User bisa memiliki banyak Transaksi (One to Many).
     */
    public function transaksi(): HasMany
    {
        // Parameter kedua ('id_user') adalah foreign key di tabel 'transaksi'
        // yang menghubungkan ke tabel 'users'.
        return $this->hasMany(Transaksi::class, 'id_user');
    }
}