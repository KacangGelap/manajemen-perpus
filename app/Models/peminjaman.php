<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey= 'id';
    protected $fillable =[
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_denda',
        'jumlah_denda',
        'jumlah_dibayar',
        'status_pembayaran'
    ];
    public function anggota(){
        return $this->belongsTo('App\models\anggota');
    }
}
