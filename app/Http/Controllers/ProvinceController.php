<?php

namespace App\Http\Controllers;

use App\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titlePage = "Thêm Tỉnh";
        $provinces = Province::paginate(Province::PAGINATE);
        return view('add.province', compact('titlePage','provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titlePage = "Thêm Tỉnh";

        return view('add.province',compact('titlePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Province::create($request->all());
        return redirect()->back()->with('msg', __('messages.success.create'));
    }

    public function getDistrict(Request $request)
    {
        $respon = [
            'districts' => Province::findOrFail($request->id)->districts()->orderBy('name')->get(),
        ];
        return response()->json($respon);
    }

    public function edit(Province $province)
    {
        //
    }

    public function update(Request $request, Province $province)
    {
        //
    }

    public function destroy($id)
    {
        if(count(Province::findOrFail($id)->districts) != 0)
        {
            return redirect()->back()->with('delete_notice_failed', 'Xóa thất bại');
        }
        else{
            Province::findOrFail($id)->delete();
            return redirect()->back()->with('delete_notice_success', 'Xóa thành công');
        }
    }
}
