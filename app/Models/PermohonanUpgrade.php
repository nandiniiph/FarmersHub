<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanUpgrade extends Model
{
    use HasFactory;
    protected $table = 'permohonan_upgrade';
    protected $primaryKey = 'permohonan_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'tanggal_permohonan',
        'nama_lengkap',
        'nomor_hp',
        'nama_usaha',
        'alamat_lengkap',
        'status',
        'catatan_admin'
    ];

    protected $dates = [
        'tanggal_permohonan',
    ];

    public function Akun(){
        return $this->belongsTo(Akun::class, 'user_id');
    }
}
