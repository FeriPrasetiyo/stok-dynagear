<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = [
        'tanggal',
        'product_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'keterangan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}