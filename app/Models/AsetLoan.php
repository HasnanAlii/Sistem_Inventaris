<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id', 'user_id', 'jumlah', 'tanggal_pinjam', 'tanggal_kembali', 'status'
    ];

    protected $dates = [
        'tanggal_pinjam', 'tanggal_kembali',
    ];

    protected $casts = [
    'tanggal_pinjam' => 'date',
    'tanggal_kembali' => 'date',

    ];


    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
