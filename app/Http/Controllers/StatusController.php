<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product()
    {
        $titlePage = "Tình Trạng Sản Phẩm";
        $statuses = Status::where('type', Status::PRODUCT)->orderBy('id', 'DESC')->get();
        return view('add.status_product',compact('titlePage', 'statuses'));
    }

    public function storeProduct(Request $request)
    {
        Status::create([
            'name' => $request->name,
            'type' => Status::PRODUCT,
        ]);
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order()
    {
        $titlePage = "Trạng thái đơn hàng";
        $statuses = Status::where('type', Status::ORDER)->orderBy('id', 'DESC')->get();
        return view('add.status_order',compact('titlePage', 'statuses'));
    }

    public function storeOrder(Request $request)
    {
        Status::create([
            'name' => $request->name,
            'type' => Status::ORDER,
        ]);
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */

    // Xóa tình trạng sản phẩm
    public function destroy($id)
    {
        if(count(Status::findOrFail($id)->productSuppliers) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Status::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }

    // Xóa tình trạng sản phẩm
    public function deleteStatusOrder($id)
    {
        if(count(Status::findOrFail($id)->orders) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Status::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }
}
