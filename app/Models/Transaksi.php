<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tanggal_transaksi',
        'total_harga',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(Akun::class, 'user_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,
            DetailTransaksi::class,
            'transaksi_id',
            'product_id',
            'transaksi_id',
            'product_id'
        );
    }
}
