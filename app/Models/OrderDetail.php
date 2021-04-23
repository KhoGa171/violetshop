<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';

    protected $fillable = [
        'order_id',
        'product_id',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
