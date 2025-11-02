<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id',
        'tanggal',
        'jenis_perbaikan',
        'biaya',
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
