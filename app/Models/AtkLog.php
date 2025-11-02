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

    
    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
    ];

    public function atk()
    {
        return $this->belongsTo(Atk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
