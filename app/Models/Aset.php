<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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


public function maintenanceLogs()
{
return $this->hasMany(MaintenanceLog::class);
}


// public function assessments()
// {
// return $this->hasMany(AsetAssessment::class);
// }


public function getUmurAttribute()
{
return now()->year - $this->tanggal_perolehan->year;
}
}