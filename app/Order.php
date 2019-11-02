<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'deposit',
        'ship_fee',
        'note',
        'type_id',
        'status_id',
        'transport_id',
        'customer_id',
        'user_id',
        'total',
        'order_source_id'
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function orderSource()
    {
        return $this->belongsTo(OrderSource::class);
    }

    public function getSumProductAttribute()
    {
        // return $this->orderProducts->count();
        return $this->orderProducts->sum('number');
    }

    public function getSumImportPriceAttribute()
    {
        return $this->orderProducts->sum('total_import_price');
    }
}
