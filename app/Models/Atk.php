<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'stok_minimum',
        'harga_satuan',
        'total_harga',
        'kondisi',
        'tanggal_masuk',
        'keterangan',
        'created_by',
        'procurement_id', // relasi ke pengadaan
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'harga_satuan' => 'integer',
        'tanggal_masuk' => 'date',
    ];

    // 🔹 Relasi ke user (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 🔹 Relasi ke log ATK
    public function logs()
    {
        return $this->hasMany(AtkLog::class);
    }

    // 🔹 Relasi ke permintaan ATK (jika ada)
    public function permintaanAtks()
    {
        return $this->hasMany(PermintaanAtk::class);
    }

    // 🔹 Relasi ke pengadaan
    public function procurement()
    {
        return $this->belongsTo(AtkProcurement::class, 'procurement_id');
    }

    // 🔹 Scope stok menipis
    public function scopeMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
}
