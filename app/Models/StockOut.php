<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'warehouse_id',
        'tanggal',
        'tujuan',
        'nomor_so',
        'keterangan',
    ];

    public function details()
    {
        return $this->hasMany(StockOutDetail::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}