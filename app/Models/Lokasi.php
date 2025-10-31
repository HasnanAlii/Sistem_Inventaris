<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode', 'gedung', 'lantai', 'keterangan'];

    public function asets()
    {
        return $this->hasMany(Aset::class);
    }
}
