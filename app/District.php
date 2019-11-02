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

    public static function getDistrict($id)
    {
        return District::where('id', $id)
            ->select('id as district_id', 'name as district_name', 'province_id')
            ->first();
    }
}
