<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode', 'deskripsi'];

    public function asets()
    {
        return $this->hasMany(Aset::class);
    }
}
