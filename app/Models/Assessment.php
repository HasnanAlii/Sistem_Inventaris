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
        'notes',
        'score',
        'status',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
