<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtkLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'atk_id',
        'user_id',
        'jumlah',
        'status',
        'tanggal_permintaan',
        'tanggal_persetujuan',
    ];

    /**
     * Cast otomatis kolom tanggal ke format datetime (Carbon instance)
     */
    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
    ];

    // Relasi ke tabel ATK
    public function atk()
    {
        return $this->belongsTo(Atk::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
