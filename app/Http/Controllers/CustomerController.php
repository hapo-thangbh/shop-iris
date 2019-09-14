<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function editAddress(Request $request)
    {
        Customer::findOrFail($request->id)->update([
           'address' => $request->address
        ]);
    }

    public function info(Request $request)
    {
        $customer = Customer::with('orders.orderProducts.product', 'orders.orderProducts.type')->findOrFail($request->id);
        return response()->json(['customer' => $customer]);
    }

    public function report(Request $request)
    {
        $customers = Customer::with('type', 'orders');
        if ($request->phone) {
            $customers->where('phone', 'LIKE', '%' . $request->phone . '%');
        }
        $respon = [
            'titlePage' => 'Thống Kê Khách Hàng',
            'customers' => $customers->paginate(Customer::PAGINATE),
            'request' => $request,
        ];
        return view('report.customer', $respon);
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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
