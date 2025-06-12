<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primaryKey = 'cart_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
    ];

    public function Akun(){
        return $this->belongsTo(Akun::class, 'user_id');
    }

    public function DetailKeranjang(){
        return $this->hasMany(DetailKeranjang::class, 'cart_id');
    }
}
