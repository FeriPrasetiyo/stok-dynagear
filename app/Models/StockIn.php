<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'warehouse_id',
        'tanggal',
        'supplier',
        'nomor_dokumen',
        'keterangan',
    ];

    public function details()
    {
        return $this->hasMany(StockInDetail::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}