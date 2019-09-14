<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'name',
        'address',
        'phone'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('number', 'price', 'status_id', 'type_id');
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }
}
