<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang', 'jumlah', 'biaya', 'tanggal_pengadaan'
    ];
    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
     protected $casts = [
        'tanggal_pengadaan' => 'datetime',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
       public function asets()
    {
        return $this->hasMany(Aset::class, 'aset_log_id');
    }

}
