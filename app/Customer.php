<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'name',
        'address',
        'link',
        'phone',
        'district_id',
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalMoneyAttribute()
    {
        $total = 0;
        foreach ($this->orders as $order) {
            $total += $order->total - $order->discount;
        }
        return $total;
    }

    public function getTotalProductAttribute()
    {
        $total = 0;
        foreach ($this->orders as $order) {
            $total += $order->sum_product;
        }
        return $total;
    }
}
