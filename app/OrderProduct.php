<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $fillable = [
        'product_id',
        'order_id',
        'number',
        'price',
        'type_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function getTotalImportPriceAttribute()
    {
        $total = $this->product->import_prince * $this->number;
        return $total;
    }
}
