<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id', 'user_id', 'type', 'keterangan'
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
