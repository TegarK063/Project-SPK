<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kriteria extends Model
{
    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'type',
        'bobot',
    ];
}