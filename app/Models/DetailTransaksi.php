<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'detail_transaksi_id';
    public $timestamps = true;
    protected $fillable = [
        'transaksi_id',
        'product_id',
        'jumlah',
        'harga_satuan'
    ];

    public function Transaksi(){
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function Produk(){
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
