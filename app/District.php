<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'name',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
