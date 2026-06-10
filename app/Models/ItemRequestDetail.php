<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRequestDetail extends Model
{
    protected $fillable = [
        'item_request_id',
        'product_id',
        'qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}