<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Status;
use App\OrderSource;
use App\Order;

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
