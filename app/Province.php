<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Status;
use App\OrderSource;

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

//    public function getAmountByOrderSource ()
//    {
//        $data = [];
//        $province = $this->with('districts.customers.orders.status')
//            ->where('districts.customers.orders.status', function ($query) {
//            $query->whereIn('name', ['Đã gửi', 'Hoàn thành'])->where('type', Status::ORDER);
//        });
//        $orderSources = OrderSource::all();
//        foreach ($orderSources as $orderSource) {
//            $data[$orderSource->name] = $province->where('districts.customers.orders')
//        }
//    }
}
