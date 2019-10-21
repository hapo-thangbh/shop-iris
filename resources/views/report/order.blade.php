@extends('layouts.app')

@section('content')
    @php($i = 0)
    <div class="container-fluid">
        <div class="row mt-1">
            <a class="ml-1 col-md-2 btn btn-danger" href="{{ route('product.export') }}">+ Bán hàng</a>
        </div>
        <form class="row" action="{{ route('report.order') }}" method="GET" id="form-search-order">
            <div class="form-inline w-100">
                <input type="text" class="form-control mx-1 col-2" placeholder="SĐT, mã đơn, tên khách" name="code" value="{{ $request->code }}">
                <div class="mx-1 my-1">
                    <select class="form-control select2" name="status_id">
                        <option value="">Trạng thái (tất cả)</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $status->id == $request->status_id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mx-1 my-1">
                    <select class="form-control select2" name="order_source_id">
                        <option value="">Nguồn đơn (tất cả)</option>
                        @foreach($orderSources as $orderSource)
                            <option value="{{ $orderSource->id }}" {{ $orderSource->id == $request->order_source_id ? 'selected' : '' }}>
                                {{ $orderSource->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mx-1 my-1">
                    <select class="form-control select2" name="transport_id">
                        <option value="">Vận chuyển (tất cả)</option>
                        @foreach($transports as $transport)
                            <option value="{{ $transport->id }}" {{ $transport->id == $request->transport_id ? 'selected' : '' }}>
                                {{ $transport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mx-1 my-1">
                    <select class="form-control select2" name="province_id">
                        <option value="">Tỉnh (tất cả)</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ $province->id == $request->province_id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="date" class="form-control mx-1 my-1" name="start_date" value="{{ $request->start_date }}">
                <input type="date" class="form-control mx-1 my-1" name="end_date" value="{{ $request->end_date }}">
                <input type="hidden" name="search" value="1">
                <button type="submit" class="btn btn-danger mx-1">Tìm</button>
            </div>
        </form>

        <div class="row w-100">
            <div class="col-12 form-inline">
            @foreach($statuses as $status)
                    <form action="{{ route('report.order') }}" method="GET">
                        <input type="hidden" name="search" value="1">
                        <input type="hidden" name="status_id" value="{{ $status->id }}">
                    <button type="submit" class="mx-1 btn btn-{{ request('status_id') == $status->id ? 'primary' : 'danger' }}">{{ $status->name }} ({{ $status->orders->count() }})</button>
                </form>
            @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <?php $stt=1 ?>
            @foreach($orders as $order)
                <div class="col-md-3 mt-3 h-auto">
                    <div class="px-2 border border-danger shadow pb-2 h-100">
                        <input type="text" hidden="" value="{{$stt++}}">
                        <div class="pt-2 pb-2">
                            <i class="mr-2 fa fa-user" aria-hidden="true"></i>
                            <span onclick="setInfoCustomer({{ $order->customer->id }})">{{ $order->customer->name }}</span>
                            <span class="float-right text-danger">{{ $order->id }}</span>
                        </div>
                        <div class="pt-2 pb-2">
                            <i class="mr-2 fas fa-map-marker-alt"></i>
                            <span id="address{{ $stt }}" title="{{ $order->customer->address }}">{{ str_limit($order->customer->address, 25) }}</span>
                            <i class="fas fa-pen ml-2 cursor-pointer" onclick="setEditAddress('{{ $stt }}', '{{ $order->customer->id }}')"></i>
                        </div>
                        <div class="pt-2 pb-2">
                            <i class="mr-2 fa fa-phone" aria-hidden="true"></i>
                            <span onclick="clickPhone($(this).text());" class="order-phone
                                @if(!empty($array_customer_id))
                                    @foreach($array_customer_id as $customer_id)
                                        @if($order->customer_id == $customer_id)
                                            text-success
                                        @endif
                                    @endforeach
                                @endif
                            ">{{ $order->customer->phone }}</span>
                        </div>
                        <div class="pt-2 pb-2">
                            <i class="mr-2 fa fa-shopping-basket" aria-hidden="true"></i>
                            <span class="attribute-product">
                                {{ $order->orderProducts[0]->product->code.$order->orderProducts->first()->type->code }}
                                ({{ $order->orderProducts[0]->number }});
                                <img src="{{ asset('storage/'.$order->orderProducts[0]->product->image) }}">
                            </span>

                            <?php $check = 0 ?>
                            @foreach($order->orderProducts as $orderProduct)
                                @if($check)
                                    <span class="attribute-product">{{ $orderProduct->product->code.$orderProduct->type->code }}
                                        ({{ number_format($orderProduct->number) }});
                                        <img src="{{ asset('storage/'.$orderProduct->product->image) }}">
                                    </span>
                                @endif
                                <?php $check++ ?>
                            @endforeach

                        </div>
                        <div class="pt-2 pb-2">
                            <i class="mr-2 far fa-calendar-alt"></i>
                            <span id="note{{ $stt }}">{{ $order->note }}</span>
                            <i class="fas fa-pen ml-2 cursor-pointer" onclick="setEditNote('{{ $stt }}', '{{ $order->id }}')"></i>
                        </div>
                        <div class="pt-2 pb-2">
                            <i class="mr-2 fas fa-dollar-sign"></i>
                            <span class="text-danger">{{ number_format($order->total + $order->ship_fee - $order->discount) }} VNĐ</span>
                        </div>
                        <div class="pt-2 pb-2 form-inline">
                            <span>{{ date_format($order->created_at,"d/m/Y") }}</span> <span class="ml-2 mr-2">{{ date_format($order->created_at,"H:i") }}</span>
                            <select class="form-control d-inline-block" onchange="editStatus($(this).val(), {{ $order->id }})">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ ($order->status_id == $status->id) ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <a class="mt-2 fa fa-print text-dark pl-2" aria-hidden="true" href="{{ route('print_order', $order->id) }}"></a>
                            <i class="mt-2 mr-2 fas fa-pen pl-2 cursor-pointer" aria-hidden="true"  onclick="getInfoOrder({{ $order->id }})"></i>
                            <a class="mt-2 fas fa-plus text-dark pl-2" aria-hidden="true" href="{{ route('product.export_for_customer', $order->customer->id) }}"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $orders
            ->appends([
                'phone' => $request->phone,
                'status_id' => $request->status_id,
                'order_source_id' => $request->order_source_id,
                'transport_id' => $request->transport_id,
                'province_id' => $request->province_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'search' => 1,
            ])
            ->links() }}
        </div>
    </div>
    <button class="d-none" data-toggle="modal" data-target="#infoOrder" id="btnModalInfoOrder"></button>
    <button type="button" id="btnModalNote" class="d-none" data-toggle="modal" data-target="#editNote"></button>
    <button type="button" id="btnModalAddress" class="d-none" data-toggle="modal" data-target="#editAddress"></button>
    <button class="d-none" id="btnInfoCustomer" data-toggle="modal" data-target="#historyOrder"></button>
    <div class="modal fade" id="editAddress">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-body">
                    <textarea class="form-control" id="getEditAddress"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="btnSaveEditAddress">Lưu</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editNote">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-body">
                    <textarea class="form-control" id="getEditNote"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="btnSaveEditNote">Lưu</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="historyOrder">
        <div class="modal-dialog">
            <div class="modal-content border-0">

                <!-- Modal Header -->
                <div class="modal-header bg-danger w-100">
                    <h4 class="modal-title text-white">Lịch sử giao dịch khách hàng</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h4>KH: <span id="infoCustomerName"></span></h4>
                    <ul id="infoOrders">
                    </ul>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="infoOrder">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0" id="tableOrder">
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function clickPhone(phone) {
            var string = window.location.toString();
            if(string.indexOf("?") == -1) {
                window.location.href = location + '?phone=' + phone;
            }
            else {
                window.location.href = location + '&phone=' + phone;
            }
        }
        let stt = 0;
        function setEditAddress(stt, id) {
            $('#getEditAddress').val($(`#address${stt}`).text());
            $('#btnModalAddress').trigger('click');
            $('#btnSaveEditAddress').click(function () {
                $.ajax({
                    url: "{{ route('customer.edit_address') }}",
                    type: "POST",
                    data: {
                        id: id,
                        address: $('#getEditAddress').val(),
                    },
                    success: function () {
                        $(`#address${stt}`).text($('#getEditAddress').val());
                        $('#editAddress').modal('hide');
                    },
                    errors: function () {
                        alert('Lỗi server!!!, Thay đổi địa chỉ thất bại');
                    }
                })
            })
        }
        function setEditNote(stt, id) {
            $('#getEditNote').val($(`#note${stt}`).text());
            $('#btnModalNote').trigger('click');
            $('#btnSaveEditNote').click(function () {
                $.ajax({
                    url: "{{ route('order.edit_note') }}",
                    type: "POST",
                    data: {
                        id: id,
                        note: $('#getEditNote').val(),
                    },
                    success: function () {
                        $(`#note${stt}`).text($('#getEditNote').val());
                        $('#editNote').modal('hide');
                    },
                    errors: function () {
                        alert('Lỗi server!!!, Thay đổi ghi chú thất bại');
                    }
                })
            })
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
        function editStatus(value, id) {
            let x = confirm('Xác nhận thay đổi trạng thái đơn hàng.');
            if (x) {
                $.ajax({
                    url: "{{ route('order.edit_status') }}",
                    type: "POST",
                    data: {
                        id: id,
                        status_id: value,
                    },
                    success: function () {
                        location.reload();
                    },
                })
            }
        }
        function setInfoCustomer(id) {
            $.ajax({
                url: "{{ route('customer.info') }}",
                type: "POST",
                data: {
                    id: id,
                },
                success: function (respon) {
                    let text = ``;
                    let text2 = ``;
                    $('#infoCustomerName').text(respon.customer.name);
                    $.each( respon.customer.orders, function( key, value ) {
                        $.each( value.order_products, function( key2, value2 ) {
                            text2 +=`<li>${value2.product.name} ${value2.type.name}</li>`
                        });
                        text += `<li>
                            ${value.created_at}
                            <ul>${text2}</ul>
                        </li>`;
                    });
                    $('#infoOrders').html(text);
                    $('#btnInfoCustomer').trigger('click');
                },
                errors: function () {
                    alert('Lỗi server!!!, Không lấy được thông tin');
                }
            })
        }
        function getInfoOrder(id) {
            $.ajax({
                url: "{{ route('order.info') }}",
                type: "POST",
                data: {
                    id: id,
                },
                success: function (respon) {
                    $('#tableOrder').html(respon);
                    stt = $('#stt').val() - 1;
                    for (let i = 0; i <= stt; i++) {
                        setProduct(i);
                    }
                    stt++;
                    $('#btnModalInfoOrder').trigger('click');
                },
                errors: function () {
                    alert('Lỗi server!!!, Không lấy được thông tin');
                }
            })
        }
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
        function addOrder() {
            stt++;
            let text = `<tr>
                <td class="text-center font-weight-bold">${stt + 1}</td>
                <td>
                    <select class="form-control select2" id="" name="product[${stt}][name]" onchange="setProduct(${stt}); setType(${stt});">
                        <option value=""></option>
                        @foreach($products as $product)
                        <option value="{{ $product }}">{{ $product->code }}</option>
                        @endforeach
                    </select>
                </td>
                <td id="selectType${stt}">
                    <select class="form-control select2" id="" name="product[${stt}][type]" onchange="setProduct(${stt})">
                        <option value=""></option>
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
                <td class="text-center"><button type="button" id="delete${stt}" class="btn-del-attr btn bg-danger" onclick="deleteOrder(${stt});">Xóa</button></td>
            </tr>`;
            $('#order').append(text);
            setProduct(stt);
            $(".select2").select2({
            });
        }

        function deleteOrder(id) {
            var sum_old = parseInt($(`#sumPrice`).html());
            var money = parseInt($(`#money${parseInt(id)}`).html());
            var tong = parseInt(sum_old-money);
            var tongcong_old = parseInt($(`#total`).html());
            var tongcong = parseInt(tongcong_old-money);
            $('#sumPrice').html(tong);
            $('#total').html(tongcong);
            $(`#delete${id}`).closest('tr').remove();
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
                    if ($(`select[name="product[${i}][name]"]`).val())
                    {
                        price = JSON.parse($(`select[name="product[${i}][name]"]`).val()).export_prince * $(`input[name="product[${i}][number]"]`).val();
                    }
                    else{
                        price = parseInt('0');
                    }
                    sumPrice += price;
                }
                $('#sumPrice').text(sumPrice);
            }
            setSale();
            setShip()
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
