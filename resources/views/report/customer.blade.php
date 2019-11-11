@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <form class="w-100">
            <form class="row" action="{{ route('report.customer') }}">
                <div class="col-12">
                    <h1 class="title d-inline-block">DANH SÁCH KHÁCH HÀNG</h1>
                    <button type="submit" class="btn btn-danger col-4 col-md-2 mb-2 float-right">Tìm</button>
                    <input type="text" class="form-control col-12 col-md-4 mr-2 float-right" id="" name="phone" placeholder="Số điện thoại" value="{{ $request->phone }}">
                </div>
            </form>
            <div class="row mt-3">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered">
                        <tr class="text-center bg-danger text-white">
                            <th>STT</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Loại</th>
                            <th>Tổng tiền</th>
                            <th>Số lần mua</th>
                            <th>SL SP</th>
                            <th>Hành động</th>
                        </tr>
                        <?php $stt = 1 ?>
                        @foreach($customers as $customer)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $stt++ }}</td>
                                <td>{{ $customer->name }}</td>
                                <td class="text-center">{{ $customer->phone }}</td>
                                <td>{{ $customer->type->name }}</td>
                                <td class="text-center">{{ number_format($customer->total_money) }}</td>
                                <td class="text-center">{{ $customer->orders->count() }}</td>
                                <td class="text-center">{{ $customer->total_product}}</td>
                                <td>
                                    <a href="{{ route('product.export_for_customer', $customer->id) }}" class="btn btn-danger w-100">Tạo đơn mới</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $customers->appends(['phone' => $request->phone])->links() }}
                </div>
            </div>
        </form>
    </div>
@endsection

