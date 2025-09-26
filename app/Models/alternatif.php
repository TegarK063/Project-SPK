<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alternatif extends Model
{
    protected $fillable = [
        'kode_alternatif',
        'product_id',
        'performance',
        'camera',
        'battery',
        'aftersales',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}