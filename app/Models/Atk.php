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
        // 'satuan',
        'stok',
        'stok_minimum',
        'harga_satuan',
        'kondisi',
        'tanggal_masuk',
        'keterangan',
        'created_by',
    ];
    protected $casts = [
        'stok' => 'integer',
    ];

    // Relasi ke user (jika ada login user)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
        public function logs()
    {
        return $this->hasMany(AtkLog::class);
    }

    // Scope untuk stok menipis
    public function scopeMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
    public function permintaanAtks()
{
    return $this->hasMany(PermintaanAtk::class);
}

}
