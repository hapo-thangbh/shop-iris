<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    const ORDER = 3;
    const CUSTOMER = 2;
    const PRODUCT = 1;
    protected $fillable = [
      'name', 'code' ,'level'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }

    public function orderProduct()
    {
        return $this->hasOne(OrderProduct::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
