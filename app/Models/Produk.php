<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'product_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar'
    ];

    public function Akun(){
        return $this->belongsTo(Akun::class, 'user_id');
    }

    public function DetailKeranjang(){
        return $this->hasMany(DetailKeranjang::class, 'product_id');
    }

    public function DetailTransaksi(){
        return $this->hasMany(DetailTransaksi::class, 'product_id');
    }
}
