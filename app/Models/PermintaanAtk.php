<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanAtk extends Model
{
    use HasFactory;

    protected $fillable = [
        'atk_id',
        'user_id',
        'jumlah',
        'status',
        'tanggal_permintaan',
        'keterangan',
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
