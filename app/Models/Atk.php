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
        'satuan',
        'kategori_id',
        'stok_minimum',
        'harga_satuan',
        'total_harga',
        'tanggal_masuk',
        'created_by',
        'procurement_id',
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'harga_satuan' => 'integer',
        'tanggal_masuk' => 'date',
    ];

      public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs()
    {
        return $this->hasMany(AtkLog::class);
    }

    public function permintaanAtks()
    {
        return $this->hasMany(PermintaanAtk::class);
    }

    public function procurement()
    {
        return $this->belongsTo(AtkProcurement::class, 'procurement_id');
    }

    public function scopeMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
}
