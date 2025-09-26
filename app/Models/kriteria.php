<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kriteria extends Model
{
    protected $fileable = [
        'kode_kriteria',
        'nama_kriteria',
        'type',
        'bobot',
    ];
}
