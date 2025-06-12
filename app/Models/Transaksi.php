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

    public function Akun(){
        return $this->belongsTo(Akun::class, 'user_id');
    }

    public function DetailTransaksi(){
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
