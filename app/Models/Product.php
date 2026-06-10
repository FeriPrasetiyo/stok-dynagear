<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'warehouse_id',
        'kode_barang',
        'nama_barang',
        'kategori',
        'satuan',
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
}