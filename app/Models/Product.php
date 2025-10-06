<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'image',
        'series',
        'storage',
        'description',
        'price',
        'link'
    ];
    public function alternatifs()
    {
        return $this->hasMany(alternatif::class);
    }
}
