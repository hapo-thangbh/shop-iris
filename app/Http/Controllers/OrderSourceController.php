<?php

namespace App\Http\Controllers;

use App\OrderSource;
use Illuminate\Http\Request;

class OrderSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titlePage = "Thêm Nguồn Hàng";
        $orderSources = OrderSource::all();
        return view('add.order_source',compact('titlePage', 'orderSources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        OrderSource::create($request->all());
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderSource  $orderSource
     * @return \Illuminate\Http\Response
     */
    public function show(OrderSource $orderSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderSource  $orderSource
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderSource $orderSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderSource  $orderSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderSource $orderSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderSource  $orderSource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(count(OrderSource::findOrFail($id)->orders) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            OrderSource::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }
}
