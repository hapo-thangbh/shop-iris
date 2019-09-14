<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'name'
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
