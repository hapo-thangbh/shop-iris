<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    const PAGINATE = 10;
    protected $table = 'product_supplier';
    protected $fillable = [
        'product_id',
        'supplier_id',
        'number',
        'price',
        'status_id',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalImportPriceAttribute()
    {
        $total = $this->product->import_prince * $this->number;
        return $total;
    }

    public function getTotalWaitSendAttribute()
    {
        return OrderProduct::where('product_id', $this->product_id)
            ->where('type_id', $this->type_id)
            ->whereHas('order.status', function($query) {
                $query->where('type', Status::ORDER)->where('name', 'Chờ gửi');
            })->sum('number');
    }

    public function getTotalExportAttribute()
    {
        return OrderProduct::where('product_id', $this->product_id)
            ->where('type_id', $this->type_id)
            ->whereHas('order', function($query) {
                $query ->whereIn('status_id', [2, 3, 5]);
            })->sum('number');
    }

    public function getTotalImportAttribute()
    {
        return ProductSupplier::where('product_id', $this->product_id)
            ->where('type_id', $this->type_id)
            ->sum('number');
    }

    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }
    public function getTypeCodeAttribute()
    {
        return $this->type->code;
    }
}
