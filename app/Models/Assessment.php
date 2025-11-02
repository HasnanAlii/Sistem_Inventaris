<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id',       
        'condition',     
        'score',         
        'usia_bulan',    
        'perbaikan',    
        'status',       
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke aset
     */
    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    /**
     * Boot method untuk otomatis mengisi usia_bulan & perbaikan
     */
    protected static function booted()
    {
        static::creating(function ($assessment) {
            if ($assessment->aset) {
                $assessment->usia_bulan = $assessment->aset->umur_bulan;
                $assessment->perbaikan = $assessment->aset->maintenanceLogs()->count();
            }
        });

        static::updating(function ($assessment) {
            if ($assessment->aset) {
                $assessment->usia_bulan = $assessment->aset->umur_bulan;
                $assessment->perbaikan = $assessment->aset->maintenanceLogs()->count();
            }
        });
    }
}
