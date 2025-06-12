<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKeranjang extends Model
{
    use HasFactory;
    protected $table = 'detail_keranjang';
    protected $primaryKey = 'detail_keranjang_id';
    public $timestamps = true;
    protected $fillable = [
        'cart_id',
        'product_id',
        'jumlah',
    ];

    public function Keranjang(){
        return $this->belongsTo(Keranjang::class, 'cart_id');
    }

    public function Produk(){
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
