<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const PAGINATE = 10;
    protected $fillable = [
        'supplier_id',
        'code',
        'name',
        'import_prince',
        'export_prince',
        'unit',
        'image',
        'user_id',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('number', 'price', 'status_id', 'type_id');
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }

    public function total($type)
    {
        $products = $this->productSuppliers->where('type_id', $type);
        return $products->sum('number');
    }
  
    public function getTotalImportNumberAttribute()
    {
        return $this->productSuppliers->sum('number');
    }

    public function getTotalExportNumberAttribute()
    {
        $value =  $this->orderProducts()->whereHas('order', function($query) {
            $query ->whereIn('status_id', [2, 3, 5]);
        })->sum('number');
        return $value;
    }

    public function getTotalMoneyAttribute()
    {
        $value = ($this->total_import_number - $this->total_export_number) * $this->import_prince;
        return $value;
    }

    public static function search($request)
    {
        $products = Product::with('category', 'productSuppliers.type')->orderBy('created_at', 'DESC');
        // $products = Product::with(['productSuppliers.type' => function ($q) {
        //     $q->orderBy('code', 'desc')->get();
        // }])->orderBy('created_at', 'DESC');
        if ($request->code_search) {
            $products->where('code', 'LIKE', "%$request->code_search%");
        }
        if ($request->name_search) {
            $products->where('name', 'LIKE', "%$request->name_search%");
        }
        if ($request->category_search) {
            $products->where('category_id', $request->category_search);
        }
        if ($request->supplier_search) {
            $products->where('supplier_id', $request->supplier_search);
        }
        if ($request->start_date_search) {
            $products->where('created_at', '>=', $request->start_date_search);
        }
        if ($request->end_date_search) {
            $toDate = strtotime(date("Y-m-d", strtotime($request->end_date_search)) . " +1 day");
            $toDate = strftime("%Y-%m-%d", $toDate);
            $products->where('created_at', '<=', $toDate);
        }
        return $products;
    }

    public function getIsExistAttribute()
    {
        if ((self::getTotalImportNumberAttribute() - self::getTotalExportNumberAttribute()) > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
