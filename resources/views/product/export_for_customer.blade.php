@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('product.store_export') }}" method="post" class="w-100" id="formSubmit">
            @csrf
            <div class="row justify-content-center">
                <div class="col-12 mb-3">
                    <h1 class="title">Thêm đơn hàng</h1>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Khách hàng</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="" name="customer_name" value="{{ $customer->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Điện thoại</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="" name="customer_phone" value="{{ $customer->phone }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Địa chỉ</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" id="" rows="3" name="customer_address">{{ $customer->address }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Tỉnh thành</label>
                        <div class="col-lg-7">
                            <select class="form-control" onchange="getDistricts($(this).val())" name="province_id">
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ ($province->id == $customer->district->province->id) ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Quận huyện</label>
                        <div class="col-lg-7">
                            <select class="form-control" name="district_id" id="district">
                                @foreach($provinces->first()->districts as $district)
                                    <option value="{{ $district->id }}" {{ ($district->id == $customer->district->id) ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Nguồn đơn hàng</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="" required name="order_source_id">
                                <option value="" class="d-none" disabled selected>Chọn nguồn..</option>
                                @foreach($orderSources as $key => $orderSource)
                                    <option value="{{ $orderSource->id }}" @if(request('is_default') && $key == 0) selected @endif>{{ $orderSource->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Loại KH</label>
                        <div class="col-lg-7">
                            <select class="form-control" id="" name="type_customer_id">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ ($type->id == $customer->type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Link thông tin KH</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="" name="url_info" value="{{ $customer->link }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-5 col-form-label">Ghi chú</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" id="" rows="3" name="note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Chiết khấu</label>
                        <div class="col-lg-4 col-md-7 col-sm-9 col-8">
                            <input type="text" class="form-control text-right" id="" name="discount" value="0" onkeyup="setSale()">
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-3 col-4">
                            <select class="form-control" id="" name="discount_type" onchange="setSale()">
                                <option value="VNĐ">VNĐ</option>
                                <option value="%">%</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Đặt cọc</label>
                        <div class="col-lg-8">
                            <input type="number" class="text-right form-control" id="" name="deposit" value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Phí ship</label>
                        <div class="col-lg-8">
                            <input type="number" class="text-right form-control" id="" name="ship" value="0" onkeyup="setShip()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Loại đơn</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" name="type_order_id" required>
                                <option value="" class="d-none" disabled selected>Chọn loại đơn..</option>
                                @foreach($typeOrders as $key => $type)
                                    <option value="{{ $type->id }}" @if(request('is_default') && $key == 0) selected @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Trạng thái</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" required name="status_id">
                                <option value="" class="d-none" disabled selected>Chọn trạng thái..</option>
                                @foreach($statuses as $key => $status)
                                    <option value="{{ $status->id }}" @if(request('is_default') && $key == 4) selected @endif>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Đơn vị vận chuyển</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="" required name="transport_id">
                                <option value="" class="d-none" disabled selected>Chọn vận chuyển..</option>
                                @foreach($transports as $key => $transport)
                                    <option value="{{ $transport->id }}" @if(request('is_default') && $key == 0) selected @endif>{{ $transport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-form-label">Mã đơn</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="" name="order_code">
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
                        <tr>
                            <td class="text-center font-weight-bold">1</td>
                            <td>
                                <select class="form-control select2" id="" name="product[0][name]" onchange="setProduct(0); setType(0)">
                                    <option value=""></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product }}">{{ $product->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="selectType0">
                                <select class="form-control select2" id="" name="product[0][type]" onchange="setProduct(0)">
                                    <option value=""></option>
                                    @foreach($typeProducts as $typeProduct)
                                        <option value="{{ $typeProduct }}">{{ $typeProduct->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="nameProduct0"></td>
                            <td class="text-center">
                                <input type="number" min="0" onkeyup="setProduct(0)" class="form-control text-center" name="product[0][number]" id="" value="1">
                            </td>
                            <td class="text-center" id="price0">
                            </td>
                            <td class="text-center" id="money0"></td>
                        </tr>
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
                            <td class="text-center" id="sale">0</td>
                        </tr>
                        <tr>
                            <th colspan="6">Phí vận chuyển</th>
                            <td class="text-center" id="ship">0</td>
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
                <div class="col-lg-3 col-md-4 col-sm-4 col-12">
                    <button type="button" class="btn btn-danger w-100" onclick="checkPrintSubmit()">Lưu và in đơn hàng</button>
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

        let $products = JSON.parse('<?= json_encode($products) ?>');
        let $typeProducts = JSON.parse('<?= json_encode($typeProducts) ?>');
        let stt = 0;
        setProduct(stt);
        function addOrder() {
            stt++;
            let text = `<tr>
                <td class="text-center font-weight-bold">${stt + 1}</td>
                <td>
                    <select class="form-control select2" id="" name="product[${stt}][name]" onchange="setProduct(${stt});  setType(${stt})">
                        @foreach($products as $product)
                <option value="{{ $product }}">{{ $product->code }}</option>
                        @endforeach
                </select>
            </td>
            <td id="selectType${stt}">
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

        function setType(id) {
            let $code = $(`select[name="product[${id}][name]"]`).val();
            if($code) {
                $.ajax({
                    url: "{{ route('product.get_type') }}",
                    method: 'GET',
                    data: {
                        stt: id,
                        id: JSON.parse($code).id,
                    },
                    success: function (respon) {
                        $(`#selectType${id}`).html(respon);
                        $(".select2").select2({
                        });
                        setProduct(id);
                    }
                })
            }
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

        function checkPrintSubmit() {
            $('input[name=checkPrint]').val(1);
            $('#formSubmit').submit();
        }
    </script>
@endsection
