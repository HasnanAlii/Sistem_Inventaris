<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Aset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_inventaris', 'nama', 'kategori_id', 'merek', 'tipe', 'serial_number',
        'tanggal_perolehan', 'umur_ekonomis', 'harga', 'lokasi_id', 'kondisi', 'status',
        'created_by', 'updated_by', 'aset_log_id'
    ];

    protected $dates = ['tanggal_perolehan'];

    protected $casts = [
        'tanggal_perolehan' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function asetLog()
    {
        return $this->belongsTo(AsetLog::class, 'aset_log_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

     public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    protected static function booted()
    {
        static::deleting(function ($aset) {
            $aset->assessments()->delete();
        });
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class, 'aset_id');
    }

    public function getUmurAttribute()
    {
        return now()->year - $this->tanggal_perolehan->year;
    }

    public function getUmurBulanAttribute()
    {
        return $this->tanggal_perolehan ? $this->tanggal_perolehan->diffInMonths(now()) : 0;
    }

    public function getUmurTahunAttribute()
    {
        return $this->tanggal_perolehan->floatDiffInYears(now());
    }

}
