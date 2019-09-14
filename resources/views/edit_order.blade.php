@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('product.store_export') }}" method="post" class="w-100" id="formSubmit">
            @csrf
            <div class="row justify-content-center">
            	<div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Khách hàng</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="" name="customer_name" value="{{ $order->customer->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Điện thoại</label>
                        <div class="col-lg-7">
                            <input type="number" class="form-control" id="" name="customer_phone" value="{{ $order->customer->phone }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Địa chỉ</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" id="" rows="3" name="customer_address">{{ $order->customer->address }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Tỉnh thành</label>
                        <div class="col-lg-7">
                            <select class="form-control" onchange="getDistricts($(this).val())" name="province_id">
                                @foreach($provinces as $province)
								 <!-- ($order->customer == $product->code) ? 'selected' : ''}} -->
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Quận huyện</label>
                        <div class="col-lg-7">
                            <select class="form-control" name="district_id" id="district">
                                @foreach($provinces->first()->districts as $districts)
                                    <option value="{{ $districts->id }}">{{ $districts->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Nguồn đơn hàng</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="" name="order_source_id">
                                @foreach($orderSources as $orderSource)
                                    <option value="{{ $orderSource->id }}" {{ ($order->orderSource->name == $orderSource->name) ? 'selected' : ''}}>{{ $orderSource->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Loại KH</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="" name="type_customer_id">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ ($order->customer->type->id === $type->id) ? 'selected' : ''}}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Link thông tin KH</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="" name="url_info" value="{{ $order->customer->link }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Ghi chú</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" id="" rows="3" name="note">{{ $order->note }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Chiết khấu</label>
                        <div class="col-lg-4 col-md-7 col-sm-9 col-8">
                            <input type="number" class="form-control text-right" id="" name="discount" value="{{ $order->discount }}" onkeyup="setSale()">
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-3 col-4">
                            <select class="form-control" id="" name="discount_type" onchange="setSale()">
                            	{!! ($order->discount_type == 'VND') ?
                                '<option value="VND" selected>VNĐ</option>
                                <option value="%">%</option>':

                                '<option value="VND">VNĐ</option>
                                <option value="%" selected>%</option>'
                            	!!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Đặt cọc</label>
                        <div class="col-lg-8">
                            <input type="number" class="text-right form-control" id="" name="deposit" value="{{ $order->deposit }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Phí ship</label>
                        <div class="col-lg-8">
                            <input type="number" class="text-right form-control" id="" name="ship" value="{{ $order->ship_fee }}" onkeyup="setShip()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Loại đơn</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" name="type_order_id">
                                @foreach($typeOrders as $type)
                                    <option value="{{ $type->id }}" {{ ($order->type->id === $type->id) ? 'selected' : ''}}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Trạng thái</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" name="status_id">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ ($order->status->id === $status->id) ? 'selected' : ''}}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Đơn vị vận chuyển</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" name="transport_id">
                                @foreach($transports as $transport)
                                    <option value="{{ $transport->id }}" {{ ($order->transport->id === $transport->id) ? 'selected' : ''}}>{{ $transport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Mã đơn</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="" name="order_code" value="{{ $order->code }}">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="text-center">
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Tên sản phẩm</th>
                            <th style="width: 100px">Số lượng</th>
                            <th>Giá bán</th>
                            <th>Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody id="order">
                    	<?php $stt=1 ?>
                    	<?php $ascending= -1 ?>
                    	@foreach ($order->orderProducts as $orderProduct)
                        <tr>
                        	<input type="text" hidden value="{{$ascending++}}" name="ascending">
                            <td class="text-center font-weight-bold">{{ $stt++ }}</td>
                            <td>
                                <select class="form-control select2" id="" name="product[{{$ascending}}][name]" onchange="setProduct({{$ascending}})">
                                    <option value=""></option>
                                    @foreach($products as $product)

                                        <option value="{{ $product }}" 
                                        {{ ($orderProduct->product->code == $product->code) ? 'selected' : ''}}
                                        >{{ $product->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" id="" name="product[{{$ascending}}][type]" onchange="setProduct({{$ascending}})">
                                    <option value=""></option>
                                    @foreach($typeProducts as $typeProduct)
                                        <option value="{{ $typeProduct }}" {{ ($orderProduct->type->code == $typeProduct->code) ? 'selected' : ''}}>{{ $typeProduct->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="nameProduct{{$ascending}}"></td>
                            <td class="text-center">
                                <input type="number" min="0" onkeyup="setProduct({{$ascending}})" class="form-control text-center" name="product[{{$ascending}}][number]" id="" value="1">
                            </td>
                            <td class="text-center" id="price{{$ascending}}">
                            </td>
                            <td class="text-center" id="money{{$ascending}}"></td>
                        </tr>
                        @endforeach
                        <input type="text" value="{{ $ascending }}" hidden name="ascending11">
                        </tbody>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-danger" onclick="addOrder()">+</button>
                            </td>
                            <td colspan="6" class="text-center text-danger"><h4>. . .</h4></td>
                        </tr>
                        <tr>
                            <th colspan="6">Cộng tiền hàng</th>
                            <td class="text-center" id="sumPrice">0</td>
                        </tr>
                        <tr>
                            <th colspan="6">Chiết khấu</th>
                            <td class="text-center" id="sale"></td>
                        </tr>
                        <tr>
                            <th colspan="6">Phí vận chuyển</th>
                            <td class="text-center" id="ship">{{$order->ship_fee}}</td>
                        </tr>
                        <tr>
                            <th colspan="6">Tổng cộng</th>
                            <td class="text-center" id="total">0</td>
                        </tr>
                    </table>
                </div>
                <input type="hidden" name="total" id="sumTotal">
                <input type="hidden" name="sumSale" id="sumSale">
                <input type="hidden" name="checkPrint" value="0">
                <div class="col-lg-3 col-md-4 col-sm-4 col-12 mb-3">
                    <button type="submit" class="btn btn-danger w-100">Lưu đơn hàng</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function getDistricts(id) {
            $.ajax({
                url: "{{ route('get.district') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function (respon) {
                    let text = '';
                    $.each( respon.districts, function( key, value ) {
                        text += `<option value="${value.id}">${value.name}</option>`;
                    });
                    $('#district').html(text);
                },
                errors: function () {
                    alert('Lỗi server chưa lấy được danh sách huyện.')
                }
            })
        }

        let stt = $(`input[name="ascending11"]`).val();
        for (var i = 0; i <= stt; i++) {
	        setProduct(i);
        }
        function addOrder() {
            stt++;
            let text = `<tr>
                <td class="text-center font-weight-bold">${stt + 1}</td>
                <td>
                    <select class="form-control select2" id="" name="product[${stt}][name]" onchange="setProduct(${stt})">
                        @foreach($products as $product)
                        <option value="{{ $product }}">{{ $product->code }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control select2" id="" name="product[${stt}][type]" onchange="setProduct(${stt})">
                    @foreach($typeProducts as $typeProduct)
                    <option value="{{ $typeProduct }}">{{ $typeProduct->code }}</option>
                    @endforeach
                </select>
            </td>
            <td id="nameProduct${stt}"></td>
            <td class="text-center">
                <input type="number" min="0" onkeyup="setProduct(${stt})" class="form-control text-center" name="product[${stt}][number]" id="" value="1">
            </td>
            <td class="text-center" id="price${stt}">
            </td>
            <td class="text-center" id="money${stt}"></td>
        </tr>`;
            $('#order').append(text);
            setProduct(stt);
            $(".select2").select2({ 
            });
        }

        function setProduct(id) {
            let sumPrice = 0;

            if($(`select[name="product[${id}][name]"]`).val() && $(`select[name="product[${id}][type]"]`).val())
            {
                $(`#nameProduct${id}`).text(JSON.parse($(`select[name="product[${id}][name]"]`).val()).name
                    + ' ' + JSON.parse($(`select[name="product[${id}][type]"]`).val()).name);
                $(`#price${id}`).text(JSON.parse($(`select[name="product[${id}][name]"]`).val()).export_prince);
                let price = JSON.parse($(`select[name="product[${id}][name]"]`).val()).export_prince * $(`input[name="product[${id}][number]"]`).val();
                $(`#money${id}`).text(price);
                for (let i = 0; i <= stt; i++) {
                    let price = JSON.parse($(`select[name="product[${i}][name]"]`).val()).export_prince * $(`input[name="product[${i}][number]"]`).val();
                    sumPrice += price;
                }
                $('#sumPrice').text(sumPrice);
            }
            setSale();
        }
        
        function setSale() {
            if ($('select[name=discount_type]').val() === '%') {
                $('#sale').text($('#sumPrice').text() * $('input[name=discount]').val() / 100);
            } else {
                $('#sale').text($('input[name=discount]').val());
            }
            setTotal();
        }

        function setShip() {
            $('#ship').text($('input[name=ship]').val());
            setTotal();
        }

        function setTotal() {
            $('#total').text(parseInt($('#ship').text()) + parseInt($('#sumPrice').text()) - parseInt($('#sale').text()));
            $('#sumTotal').val($('#sumPrice').text());
            $('#sumSale').val($('#sale').text());
        }

        function checkPrint() {
            $('input[name=checkPrint]').val(1);
            $('#formSubmit').submit();
        }
    </script>
@endsection
