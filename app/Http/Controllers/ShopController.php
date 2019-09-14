<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShopRequest;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\ProductSupplier;
use App\Shop;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $waitSend = Order::whereHas('status', function ($query) {
            $query->where('name', 'Chờ gửi')->where('type', Status::ORDER);
        })->where('created_at', '>=', date('Y-m-01'));
        $send = Order::whereHas('status', function ($query) {
            $query->where('name', 'Đã gửi')->where('type', Status::ORDER);
        })->where('created_at', '>=', date('Y-m-01'));
        $successSend = Order::whereHas('status', function ($query) {
            $query->where('name', 'Hoàn thành')->where('type', Status::ORDER);
        })->where('created_at', '>=', date('Y-m-01'));
        $respon = [
            'titlePage' => 'Doanh thu cửa hàng',
            'revenues' => [
                'waitSend' => $waitSend->sum('total') + $waitSend->sum('ship_fee') - $waitSend->sum('discount'),
                'send' => $send->sum('total') + $send->sum('ship_fee') - $send->sum('discount'),
                'successSend' => $successSend->sum('total') + $successSend->sum('ship_fee') - $successSend->sum('discount'),
            ],
            'orders' => [
                'waitSend' => $waitSend->count(),
                'send' => $send->count(),
                'successSend' => $successSend->count(),
            ],
            'importPrice' => [
                'waitSend' => $waitSend->get()->sum('sum_import_price'),
                'send' => $send->get()->sum('sum_import_price'),
                'successSend' => $successSend->get()->sum('sum_import_price'),
            ],
            'totalImport' => ProductSupplier::all()->where('created_at', '>=', date('Y-m-01'))->sum('total_import_price'),
            'totalMoney' => Product::all()->sum('total_money'),
            'totalNumber' =>  ProductSupplier::all()->sum('number') - OrderProduct::whereHas('order', function($query) {
                    $query ->whereIn('status_id', [2, 3, 5]);
                })->get()->sum('number')
        ];
        return view('report.store_sale', $respon);
    }

    public function reportAjax(Request $request)
    {
        $waitSend = Order::whereHas('status', function ($query) {
            $query->where('name', 'Chờ gửi')->where('type', Status::ORDER);
        });
        $send = Order::whereHas('status', function ($query) {
            $query->where('name', 'Đã gửi')->where('type', Status::ORDER);
        });
        $successSend = Order::whereHas('status', function ($query) {
            $query->where('name', 'Hoàn thành')->where('type', Status::ORDER);
        });
        $productSuppliers = ProductSupplier::all()->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDays(1)]);
        if ($request->start_date) {
            $waitSend->where('created_at', '>=', $request->start_date);
            $send->where('created_at', '>=', $request->start_date);
            $successSend->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $time = Carbon::parse($request->end_date)->addDays(1);
            $waitSend->where('created_at', '<=', $time);
            $send->where('created_at', '<=', $time);
            $successSend->where('created_at', '<=', $time);
        }
        $respon = [
            'titlePage' => 'Doanh thu cửa hàng',
            'revenues' => [
                'waitSend' => $waitSend->sum('total') + $waitSend->sum('ship_fee') - $waitSend->sum('discount'),
                'send' => $send->sum('total') + $send->sum('ship_fee') - $send->sum('discount'),
                'successSend' => $successSend->sum('total') + $successSend->sum('ship_fee') - $successSend->sum('discount'),
            ],
            'orders' => [
                'waitSend' => $waitSend->count(),
                'send' => $send->count(),
                'successSend' => $successSend->count(),
            ],
            'importPrice' => [
                'waitSend' => $waitSend->get()->sum('sum_import_price'),
                'send' => $send->get()->sum('sum_import_price'),
                'successSend' => $successSend->get()->sum('sum_import_price'),
            ],
            'totalImport' => $productSuppliers->sum('total_import_price'),
        ];
        return view('table_store_info_2', $respon)->render();
    }

    public function reportAjax2(Request $request)
    {
        $totalImportSale = Product::all()->sum('total_money');
        $totalNumber = ProductSupplier::all()->sum('number') - OrderProduct::whereHas('order', function($query) {
                $query ->whereIn('status_id', [2, 3, 5]);
            })->get()->sum('number');
        if ($request->time) {
            $time = Carbon::parse($request->time)->addDays(1);
            $totalImportSale = ProductSupplier::where('created_at', '<', $time)->get()->sum('total_import_price') - OrderProduct::whereHas('order', function($query) {
                    $query ->whereIn('status_id', [2, 3, 5]);
                })->where('created_at', '<', $time)->get()->sum('total_import_price');
            $totalNumber = ProductSupplier::where('created_at', '<', $time)->get()->sum('number') - OrderProduct::whereHas('order', function($query) {
                    $query ->whereIn('status_id', [2, 3, 5]);
                })->where('created_at', '<', $time)->get()->sum('number');
        }
        $respon = [
            'totalMoney' => $totalImportSale,
            'totalNumber' => $totalNumber,
        ];
        return view('table_store_info', $respon)->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $titlePage = "Thông Tin Cửa Hàng";
        $shop = Shop::firstOrFail();
        return view('store_info',compact('titlePage', 'shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopRequest $request)
    {
        Shop::firstOrFail()->update($request->all());
        return redirect()->back()->with('message', __('messages.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
