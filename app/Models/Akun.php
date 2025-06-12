<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Akun extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class, 'user_id');
    }

    public function permohonanUpgrade()
    {
        return $this->hasMany(PermohonanUpgrade::class, 'user_id');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'user_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
