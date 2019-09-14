<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductTypeRequest;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer()
    {
        $titlePage = "Thêm Loại Khách Hàng";
        $types = Type::where('level', Type::CUSTOMER)->orderBy('id', 'DESC')->paginate(10);
        return view('add.type_customer',compact('titlePage', 'types'));
    }

    public function storeCustomer(Request $request)
    {
        Type::create([
            'name' => $request->name,
            'level' => Type::CUSTOMER,
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
        $titlePage = "Thêm Loại Hóa Đơn";
        $types = Type::where('level', Type::ORDER)->orderBy('id', 'DESC')->paginate(10);
        return view('add.type_order',compact('titlePage', 'types'));
    }

    public function storeOrder(Request $request)
    {
        Type::create([
            'name' => $request->name,
            'level' => Type::ORDER,
        ]);
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function product()
    {
        $titlePage = "Thêm Loại Sản Phẩm";
        $types = Type::where('level', Type::PRODUCT)->orderBy('id', 'DESC')->paginate(10);
        return view('add.type_product',compact('titlePage', 'types'));
    }

    public function storeProduct(StoreProductTypeRequest $request)
    {
        Type::create([
           'name' => $request->name,
           'code' => $request->code,
            'level' => Type::PRODUCT,
        ]);
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */

    // Xóa loại sản phẩm
    public function destroy($id)
    {
        if(count(Type::findOrFail($id)->productSuppliers) != 0 || Type::findOrFail($id)->orderProduct != null)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Type::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }

    // Xóa loại khách hàng
    public function deleteCustomer($id)
    {
        if(count(Type::findOrFail($id)->customers) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Type::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }

    // Xóa loại đơn hàng
    public function deleteOrder($id)
    {
        if(count(Type::findOrFail($id)->orders) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Type::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }
}
