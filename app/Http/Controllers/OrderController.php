<?php

namespace App\Http\Controllers;

use DB;
use App\District;
use App\Order;
use App\OrderProduct;
use App\ProductSupplier;
use App\Province;
use App\OrderSource;
use App\Shop;
use App\Type;
use App\Product;
use App\Status;
use App\Transport;
use App\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $array_customer_id = [];
        $orders = Order::with('orderProducts.product', 'customer.district.province', 'type', 'orderProducts.type', 'orderSource', 'customer.orders')
            ->orderByDesc('updated_at');

        if (!$request->search) {
            $orders->where('status_id', 1);
            $order_customer = Order::select(DB::raw('*','count(customer_id) as amount'))->groupBy('customer_id')->get();
            foreach ($order_customer as $value) {
                if($value->amount > 1) {
                    array_push($array_customer_id, $value->customer_id);
                }
            }
        }

        if ($request->status_id) {
            $orders->where('status_id', $request->status_id);
            $order_customer = Order::where('status_id', $request->status_id)->select('*', DB::raw('count(customer_id) as amount'))->groupBy('customer_id')->get();
            foreach ($order_customer as $value) {
                if($value->amount > 1) {
                    array_push($array_customer_id, $value->customer_id);
                }
            }
        }

        if ($request->code) {
            $code = $request->code;
            $orders->where('code', $code)
            ->orwhereHas('customer', function ($query) use ($code){
                $query->where('name', 'LIKE', '%' . $code . '%');
            })->orwhereHas('customer', function ($query) use ($code){
                $query->where('phone', 'LIKE', '%' . $code . '%');
            });
        }

        if ($request->order_source_id) {
            $order_source_id = $request->order_source_id;
            $orders = $orders->where('order_source_id', $order_source_id);
        }

        if ($request->start_date) {
            $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $toDate = strtotime(date("Y-m-d", strtotime($request->end_date)) . " +1 day");
            $toDate = strftime("%Y-%m-%d", $toDate);
            $orders->where('created_at', '<=', $toDate);
        }
        if ($request->transport_id) {
            $orders->where('transport_id', $request->transport_id);
        }
        if ($request->province_id) {
            $provinceId = $request->province_id;
            $orders->whereHas('customer.district', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            });
        }
        $data = [
            'titlePage' => 'Thống kê đơn đặt hàng',
            'orders' => $orders->paginate(12),
            'statuses' => Status::with('orders')->where('type', Status::ORDER)->get(),
            'orderSources' => OrderSource::all(),
            'transports' => Transport::all(),
            'provinces' => Province::all(),
            'request' => $request,
            'typeProducts' => Type::where('level', Type::PRODUCT)->get(),
            'products' => Product::all(),
            'array_customer_id' => $array_customer_id,
        ];
        return view('report.order', $data);
    }

    public function info(Request $request)
    {
        $province_id = Order::with('orderProducts.product', 'orderProducts.type', 'customer.district')->findOrFail($request->id)->customer->district->province_id;
        $districts = District::where('province_id', $province_id)->orderBy('name')->get();

        $respon = [
            'provinces' => Province::with('districts')->orderBy('name')->get(),
            'districts' => $districts,
            'orderSources' => OrderSource::all(),
            'types' => Type::where('level', Type::CUSTOMER)->get(),
            'typeOrders' => Type::where('level', Type::ORDER)->get(),
            'statuses' => Status::where('type', Status::ORDER)->get(),
            'transports' => Transport::all(),
            'typeProducts' => Type::where('level', Type::PRODUCT)->get(),
            'products' => Product::all(),
            'order' => Order::with('orderProducts.product', 'orderProducts.type', 'customer.district')
                ->findOrFail($request->id),
        ];
        return view('report.table_order', $respon)->render();
    }

    public function editNote(Request $request)
    {
        Order::findOrFail($request->id)->update([
           'note' => $request->note
        ]);
    }

    public function editStatus(Request $request)
    {
        Order::findOrFail($request->id)->update([
            'status_id' => $request->status_id
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function printOrder($id)
    {
        $respon = [
            'titlePage' => 'In hóa đơn',
            'shop' => Shop::firstOrFail(),
            'order' => Order::with('customer', 'orderProducts.type', 'orderProducts.product')->findOrFail($id),
        ];
        return view('admin.print_form', $respon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id)->update(
            [
                'phone' => $request->customer_phone,
                'name' => $request->customer_name,
                'address' => $request->customer_address,
                'link' => $request->url_info,
                'district_id' => $request->district_id,
                'type_id' => $request->type_customer_id,
            ]
        );

        $order = Order::findOrFail($id)->update([
            'code' => $request->order_code,
            'discount' => $request->discount,
            'discount_type' => 'VND',
            'deposit' => $request->deposit,
            'ship_fee' => $request->ship,
            'note' => $request->note,
            'type_id' => $request->type_order_id,
            'status_id' => $request->status_id,
            'transport_id' => $request->transport_id,
            'total' => $request->total,
            'customer_id' => $request->customer_id,
            'order_source_id' => $request->order_source_id,
        ]);
        OrderProduct::where('order_id', $id)->delete();
        foreach ($request->product as $product) {
            if ($product['name'] && $product['type']) {
                OrderProduct::create([
                    'order_id' => $id,
                    'product_id' => json_decode($product['name'])->id,
                    'number' => $product['number'],
                    'price' => json_decode($product['name'])->export_prince,
                    'type_id' => json_decode($product['type'])->id,
                ]);
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function edit_order($id)
    {
        $data = [
            'titlePage' => 'Sửa đơn hàng',
            'provinces' => Province::with('districts')->orderBy('name')->get(),
            'orderSources' => OrderSource::all(),
            'types' => Type::where('level', Type::CUSTOMER)->get(),
            'typeOrders' => Type::where('level', Type::ORDER)->get(),
            'statuses' => Status::where('type', Status::ORDER)->get(),
            'transports' => Transport::all(),
            'products' => Product::with('types', 'productSuppliers')->get(),
            'typeProducts' => Type::where('level', Type::PRODUCT)->get(),
            'order' => Order::with('orderProducts.product', 'type', 'customer.type')->findOrFail($id)
        ];
        return view('edit_order', $data);

        $auth = Auth::user();

        $customer = Customer::update(
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



        $order = Order::findOrFail($id)->update([
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



        $order->orderProducts()->delete();

        foreach ($request->product as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => json_decode($product['name'])->id,
                'number' => $product['number'],
                'price' => json_decode($product['name'])->export_prince,
                'type_id' => json_decode($product['type'])->id,
            ]);
        }
        return redirect()->route('report.order');
    }
}
