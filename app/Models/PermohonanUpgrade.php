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
        'status',
        'catatan_admin'
    ];

    public function Akun(){
        return $this->belongsTo(Akun::class, 'user_id');
    }
}
