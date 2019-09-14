<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const ORDER = 2;
    const PRODUCT = 1;
    const PAGINATE = 10;
    protected $fillable = [
        'name', 'type'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }

    public function getWaitSendAttribute()
    {
        $orders = $this->orders();
    }
}
