<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    use HasFactory;
    protected $table = 'nota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pembayaran_id',
        'ISBN'
    ];
    public function peminjaman(){
        return $this->belongsTo('App\models\peminjaman');
    }
    public function buku(){
        return $this->belongsTo('App\models\buku');
    }
}
