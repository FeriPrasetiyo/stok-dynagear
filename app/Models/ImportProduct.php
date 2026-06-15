<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportProduct extends Model
{
    protected $table = 'import_products';

    protected $fillable = [
        'warehouse_id',
        'brand_id',
        'unit_id',
        'category_id',
        'kode_barang',
        'nama_barang',
        'stok_awal',
        'stok_minimum',
    ];
}