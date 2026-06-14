<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'warehouse_id',
        'brand_id',
        'unit_id',
        'kode_barang',
        'nama_barang',
        'category_id',
        'stok_awal',
        'stok_minimum',
        'lokasi_rak',
        'keterangan',
        'foto',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stockInDetails()
    {
        return $this->hasMany(StockInDetail::class);
    }

    public function stockOutDetails()
    {
        return $this->hasMany(StockOutDetail::class);
    }
    public function category()
    {
    return $this->belongsTo(Category::class);
    }
}