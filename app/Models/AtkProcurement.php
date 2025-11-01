<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtkProcurement extends Model
{
    use HasFactory;

        protected $fillable = [
        'nama_barang',
        'jumlah',
        'biaya',
        'tanggal_pengadaan',
    ];

    protected $dates = [
        'tanggal_pengadaan',
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atks()
    {
        return $this->hasMany(Atk::class, 'procurement_id');
    }
}
