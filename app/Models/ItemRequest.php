<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    protected $fillable = [
        'tanggal',
        'user_id',
        'nomor_request',
        'tujuan',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ItemRequestDetail::class);
    }
    

}