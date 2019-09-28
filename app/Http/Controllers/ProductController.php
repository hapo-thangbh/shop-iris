<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Http\Requests\Product\Store;
use App\Order;
use App\OrderProduct;
use App\OrderSource;
use App\Product;
use App\Province;
use App\Status;
use App\Supplier;
use App\Transport;
use App\Type;
use App\ProductSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $product = Product::findOrFail($id);
        if ($request->image) {
            $file1Extension = $request->image
                ->getClientOriginalExtension();
            $fileName1 = uniqid() . '.' . $file1Extension;
            $request->image
                ->storeAs('public', $fileName1);
            $data['image'] = $fileName1;
        }
        $product->update($data);

        $product_suppliers = $product->productSuppliers;
        foreach ($product_suppliers as $i => $product1) {
            $product1->type->update([
                'code' => $request->attribute_code[$i],
                'name' => $request->attribute_name[$i],
                'level' => 1
            ]);
        }
        $j = $product_suppliers->count();
        $amount_create = count($request->attribute_code) - $j;
        for ($i=0; $i < $amount_create; $i++) { 
            $type = Type::create([
                'code' => $request->attribute_code[$j],
                'name' => $request->attribute_name[$j],
                'level' => 1
            ]);
            ProductSupplier::create([
                'supplier_id' => $product_suppliers->first()->supplier_id,
                'product_id' => $product->id,
                'number' => 1,
                'price' => $product->import_prince,
                'status_id' => 6,
                'type_id' => $type->id,
            ]);
            $j++;
        }

        return redirect()->route('report.warehouse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $respon = [
            'titlePage' => 'Thêm sản phẩm',
            'suppliers' => Supplier::all(),
            'categories' => Category::all(),
        ];
        return view('add.product', $respon);
    }

    public function store(Store $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file1Extension = $request->file('image')
                ->getClientOriginalExtension();
            $fileName1 = uniqid() . '.' . $file1Extension;
            $request->file('image')
                ->storeAs('public', $fileName1);
            $data['image'] = $fileName1;
        }
        $data['user_id'] = Auth::user()->id;
        Product::create($data);
        if ($request->check) {
            return redirect()->back()->with('msg', trans('messages.success.create'));
        }
        return redirect()->route('report.warehouse');
    }

    public function importProduct(Request $request)
    {
        foreach ($request->product as $product) {
            $productId = json_decode($product['code'], true);
            $type_id = Type::where('name', $product['type'])->firstOrFail()->id;
            ProductSupplier::create([
                'supplier_id' => $request->supplier_id,
                'status_id' => $request->status_id,
                'product_id' => $productId['id'],
                'number' => $product['number'],
                'price' => $product['price'],
                'type_id' => $type_id
            ]);
        }
        if ($request->check) {
            return redirect()->back()->with('msg', trans('messages.success.create'));
        }
        return redirect()->route('product.import');
    }

    public function export()
    {
        $data = [
            'titlePage' => 'Bán Hàng',
            'provinces' => Province::with('districts')->orderBy('name')->get(),
            'orderSources' => OrderSource::all(),
            'types' => Type::where('level', Type::CUSTOMER)->get(),
            'typeOrders' => Type::where('level', Type::ORDER)->get(),
            'statuses' => Status::where('type', Status::ORDER)->get(),
            'transports' => Transport::all(),
            'products' => Product::with('types', 'productSuppliers')->get(),
            'typeProducts' => Type::where('level', Type::PRODUCT)->get(),
        ];
        return view('product.export', $data);
    }

    public function exportForCustomer($id)
    {
        $data = [
            'titlePage' => 'Bán Hàng',
            'provinces' => Province::with('districts')->orderBy('name')->get(),
            'orderSources' => OrderSource::all(),
            'types' => Type::where('level', Type::CUSTOMER)->get(),
            'typeOrders' => Type::where('level', Type::ORDER)->get(),
            'statuses' => Status::where('type', Status::ORDER)->get(),
            'transports' => Transport::all(),
            'products' => Product::with('types', 'productSuppliers')->get(),
            'typeProducts' => Type::where('level', Type::PRODUCT)->get(),
            'customer' => Customer::with('type', 'district.province')->findOrFail($id),
        ];
        return view('product.export_for_customer', $data);
    }

    public function exportStore(Request $request)
    {
        $auth = Auth::user();
        $customer = Customer::updateOrCreate(
            [
                'phone' => $request->customer_phone
            ],
            [
                'name' => $request->customer_name,
                'address' => $request->customer_address,
                'link' => $request->url_info,
                'district_id' => $request->district_id,
                'type_id' => $request->type_customer_id,
            ]
        );
        $order = Order::create([
            'code' => $request->order_code,
            'discount' => $request->sumSale,
            'discount_type' => 'VND',
            'deposit' => $request->deposit,
            'ship_fee' => $request->ship,
            'note' => $request->note,
            'type_id' => $request->type_order_id,
            'status_id' => $request->status_id,
            'transport_id' => $request->transport_id,
            'total' => $request->total,
            'customer_id' => $customer->id,
            'user_id' => $auth->id,
            'order_source_id' => $request->order_source_id,
        ]);
        $data = [];
        foreach ($request->product as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => json_decode($product['name'])->id,
                'number' => $product['number'],
                'price' => json_decode($product['name'])->export_prince,
                'type_id' => json_decode($product['type'])->id,
            ]);
        }

        if ($request->checkPrint) {
            return redirect()->route('print_order', $order->id);
        }
        return redirect()->route('report.order');
    }

    public function import(Request $request)
    {
        $products = ProductSupplier::with('supplier', 'product')->orderByDesc('created_at');
        if($request->code) {
            $code = $request->code;
            $products->whereHas('product', function ($query) use ($code){
                $query->where('code', 'LIKE', '%' . $code . '%');
            });
        }
        if($request->supplier_id){
            $products->where('supplier_id', $request->supplier_id);
        }
        if ($request->fromDate) {
            $products->where('created_at', '>=', $request->fromDate);
        }
        if ($request->toDate) {
            $endDate = strtotime(date("Y-m-d", strtotime($request->toDate)) . " +1 day");
            $endDate = strftime("%Y-%m-%d", $endDate);
            $products->where('created_at', '<=', $endDate);
        }
        
        $data = [
            'titlePage' => 'Thống Kê Nhập Hàng',
            'suppliers' => Supplier::all(),
            'product_suppliers' => $products->paginate(ProductSupplier::PAGINATE),
            'request' => $request,
        ];
        return view('product.import', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function reportImport()
    {
        $titlePage = "Nhập Hàng";
        $suppliers = Supplier::all();
        $statuses = Status::where('type', 1)->get();
        $products = Product::all();
        $types = Type::where('level', 1)->get();
        return view('report.import_product',compact('titlePage', 'suppliers', 'statuses', 'products', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function warehouse(Request $request)
    {
        $products = Product::search($request)->paginate(Product::PAGINATE);
        $respon = [
            'titlePage' => 'Kho hàng',
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
            'products' => $products,
            'request' => $request,
        ];
        return view('report.warehouse', $respon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function searchWarehouse(Request $request)
    {
        
    }

    public function ajaxGetType(Request $request)
    {
        $stt = $request->stt;
        $product = Product::with('productSuppliers.type')->findOrFail($request->id);
        $productSuppliers = $product->productSuppliers()->get()->unique('type_id');
        return view('product.select_type', compact('productSuppliers', 'stt'));
    }
}
