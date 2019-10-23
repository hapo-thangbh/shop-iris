<form method="POST" action="{{ route('order.update', $order->id) }}">
    <input type="hidden" name="customer_id" value="{{ $order->customer->id }}">
    <input type="hidden" name="total" id="sumTotal">
    <input type="hidden" name="sumSale" id="sumSale">
@csrf
@method('PUT')
<!-- Modal Header -->
    <div class="modal-header bg-danger w-100">
        <h4 class="modal-title text-white">Thông tin đơn hàng</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 col-12">
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
                        <select class="form-control" required onchange="getDistricts($(this).val())" name="province_id">
                            <option value="" class="d-none" disabled selected>Chọn tỉnh..</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ $order->customer->district->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-5 col-form-label">Quận huyện</label>
                    <div class="col-lg-7">
                        <select class="form-control" required name="district_id" id="district">
                            <option value="" class="d-none" disabled selected>Chọn huyện..</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ $order->customer->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-5 col-form-label">Nguồn đơn hàng</label>
                    <div class="col-lg-7">
                        <select class="form-control" id="" required name="order_source_id">
                            <option value="" class="d-none" disabled selected>Chọn nguồn..</option>
                            @foreach($orderSources as $orderSource)
                                <option value="{{ $orderSource->id }}" {{ $order->order_source_id == $orderSource->id ? 'selected' : '' }}>{{ $orderSource->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-5 col-form-label">Loại KH</label>
                    <div class="col-lg-7">
                        <select class="form-control" required id="" name="type_customer_id">
                            <option value="" class="d-none" disabled selected>Chọn loại KH..</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $order->customer->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
            <div class="col-md-6 col-12">
                <div class="form-group row">
                    <label for="" class="col-lg-4 col-form-label">Chiết khấu</label>
                    <div class="col-lg-4 col-md-7 col-sm-9 col-8">
                        <input type="number" class="form-control text-right" id="" name="discount" value="{{ $order->discount }}" onkeyup="setSale()">
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
                        <select class="form-control" id="" required name="type_order_id">
                            <option value="" class="d-none" disabled selected>Chọn loại đơn..</option>
                            @foreach($typeOrders as $type)
                                <option value="{{ $type->id }}" {{ $order->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-4 col-form-label">Trạng thái</label>
                    <div class="col-lg-8">
                        <select class="form-control" id="" required name="status_id">
                            <option value="" class="d-none" disabled selected>Chọn trạng thái..</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-4 col-form-label">Đơn vị vận chuyển</label>
                    <div class="col-lg-8">
                        <select class="form-control" id="" required name="transport_id">
                            <option value="" class="d-none" disabled selected>Chọn vận chuyển..</option>
                            @foreach($transports as $transport)
                                <option value="{{ $transport->id }}" {{ $order->transport_id == $transport->id ? 'selected' : '' }}>{{ $transport->name }}</option>
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
            <div class="col-12 mt-3">
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="order">
                    @php($i = 0)
                    @foreach($order->orderProducts as $orderProduct)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $i + 1 }}</td>
                            <td>
                                <select class="form-control select2" id="name{{ $i }}" name="product[{{ $i }}][name]" onchange="setProduct({{ $i }}); setType({{ $i }});">
                                    <option value=""></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product }}" {{ ($orderProduct->product->id == $product->id) ? 'selected' : '' }}>{{ $product->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="selectType{{ $i }}">
                                <select class="form-control select2" id="" name="product[{{ $i }}][type]" onchange="setProduct({{ $i }})">
                                    <option value=""></option>
                                    @foreach($orderProduct->product->productSuppliers->unique('type_id') as $productSupplier)
                                        <option value="{{ $productSupplier->type_id }}" {{ ($orderProduct->type_id == $productSupplier->type_id) ? 'selected' : '' }}>{{ $productSupplier->type_code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="nameProduct{{ $i }}"></td>
                            <td class="text-center">
                                <input type="number" min="0" onkeyup="setProduct({{ $i }})" class="form-control text-center" name="product[{{ $i }}][number]" id="" value="{{ $orderProduct->number }}">
                            </td>
                            <td class="text-center" id="price{{ $i }}">
                            </td>
                            <td class="text-center" id="money{{ $i }}"></td>
                            <td class="text-center"><button type="button" id="delete{{ $i }}" class="btn-del-attr btn bg-danger" onclick="deleteOrder({{ $i  }});">Xóa</button></td>
                        </tr>
                        @php($i++)
                    @endforeach
                    <tr>
                        <td class="text-center font-weight-bold">{{ $i + 1 }}</td>
                        <td>
                            <select class="form-control select2" id="" name="product[{{ $i }}][name]" onchange="setProduct({{ $i }}); setType({{ $i }});">
                                <option value=""></option>
                                @foreach($products as $product)
                                    <option value="{{ $product }}">{{ $product->code }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td id="selectType{{ $i }}">
                            <select class="form-control select2" id="" name="product[{{ $i }}][type]" onchange="setProduct({{ $i }})">
                                <option value=""></option>
                                <option value="" disabled>Chọn mã trước</option>
                            </select>
                        </td>
                        <td id="nameProduct{{ $i }}"></td>
                        <td class="text-center">
                            <input type="number" min="0" onkeyup="setProduct({{ $i }})" class="form-control text-center" name="product[{{ $i }}][number]" id="" value="1">
                        </td>
                        <td class="text-center" id="price{{ $i }}">
                        </td>
                        <td class="text-center" id="money{{ $i }}"></td>
                        <td class="text-center"><button type="button" id="delete{{ $i }}" class="btn-del-attr btn bg-danger" onclick="deleteOrder({{ $i }});">Xóa</button></td>
                    </tr>
                    </tbody>
                    <tr>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-danger" onclick="addOrder()">+</button>
                        </td>
                        <td colspan="6" class="text-center text-danger"><h4>. . .</h4></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="6">Cộng tiền hàng</th>
                        <td class="text-center" id="sumPrice">0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="6">Chiết khấu</th>
                        <td class="text-center" id="sale">0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="6">Phí vận chuyển</th>
                        <td class="text-center" id="ship">0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="6">Tổng cộng</th>
                        <td class="text-center" id="total">0</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <input type="hidden" id="stt" value="{{ $i }}">
        </div>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="edit_order">Cập nhật</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $(".select2").select2({});
    });
</script>
