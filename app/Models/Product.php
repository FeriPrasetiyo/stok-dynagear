<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'brand_id',
        'unit_id',
        'warehouse_id',
        'stok_awal',
        'stok_minimum',
        'lokasi_rak',
        'foto',
        'keterangan',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // TAMBAHKAN INI
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}