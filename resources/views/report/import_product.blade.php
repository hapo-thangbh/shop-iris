@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 offset-10 text-right">
                <a class="btn btn-danger m-1" href="{{ route('product.export') }}">+ Bán hàng</a>
            </div>
        </div>
        <div class="col-12">
            <div class="{{ session('msg') ? 'alert alert-success' : '' }}">
                {{ session('msg') ? session('msg') : '' }}
            </div>
        </div>
        <form id="formAddProduct" action="{{ route('product.import-product') }}" method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-auto">Nhà cung cấp: </div>
                <div class="col-2">
                    <select class="form-control select2" id="" name="supplier_id">
                        <option value=""></option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">Tình trạng: </div>
                <div class="col-2">
                    <select class="form-control select2" id="" name="status_id">
                        <option value=""></option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 offset-4 text-right">
                    {{ date('d-m-Y') }}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered">
                        <tr class="text-center bg-danger text-white">
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Loại sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá nhận</th>
                            <th>Thành tiền</th>
                        </tr>
                        <tr>
                            <td class="text-center font-weight-bold">1</td>
                            <td>
                                <select class="form-control select2" id="" name="product[0][code]" onchange="setProduct(0)">
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product }}">{{ $product->code }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control" id="" name="product[0][type]" onchange="setProduct(0)">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td id="nameProduct0"></td>
                            <td class="text-center">
                                <input type="number" name="product[0][number]" min="1" class="form-control w-50 m-auto text-center" value="1" onchange="setTotalMoney(0)">
                            </td>
                            <td class="text-center">
                                <input type="number" id="price0" name="product[0][price]" min="1" class="form-control text-center w-75 m-auto" onchange="setTotalMoney(0)">
                            </td>
                            <td class="text-center" id="totalMoney0"></td>
                        </tr>
                        <tbody id="add-row">
                        </tbody>
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger font-weight-bold add-row" onclick="addRow()">+</button>
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">Tổng cộng</th>
                            <td class="text-center" id="amount"></td>
                            <td class="text-center"></td>
                            <td class="text-center" id="total"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="hidden" id="checkBtn" name="check">
            <div class="row justify-content-center">
                <div class="col-3"><button type="button" id="btnSaveFirst" class="btn btn-danger w-100">Lưu</button></div>
                <div class="col-3"><button type="button" id="btnSaveSecond" class="btn btn-danger w-100">Lưu và tạo mới</button></div>
            </div>
        </form>
        
    </div>
@endsection

@section('script')
<script type="text/javascript">
    let product = JSON.parse('<?= json_encode($products) ?>');
    let type = JSON.parse('<?= json_encode($types) ?>');
    let stt = 0;
    let count = 0;
    $(document).ready(function() {
        setProduct(stt);
        setPrice(stt);
        setTotalMoney(stt);
        setTotal(stt);

        $('#btnSaveFirst').click(function () {
            $('#checkBtn').val(0);
            $('#formAddProduct').submit();
        });
        $('#btnSaveSecond').click(function () {
            $('#checkBtn').val(1);
            $('#formAddProduct').submit();
        });
    })

    function addRow() {
        stt++;
        let content = `
            <tr>
                <td class="text-center font-weight-bold">${stt + 1}</td>
                <td>
                    <select class="form-control" id="" name="product[${stt}][code]" onchange="setProduct(${stt})">
                        @foreach ($products as $product)
                            <option value="{{ $product }}">{{ $product->code }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control" id="" name="product[${stt}][type]" onchange="setProduct(${stt})">
                        @foreach ($types as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td id="nameProduct${stt}"></td>
                <td class="text-center">
                    <input type="number" id="" name="product[${stt}][number]" min="1" class="form-control w-50 m-auto text-center" value="1" onchange="setTotalMoney(${stt})">
                </td>
                <td class="text-center">
                    <input type="number" id="price${stt}" name="product[${stt}][price]" min="0" class="form-control text-center w-75 m-auto" onchange="setTotalMoney(${stt})">
                </td>
                <td class="text-center" id="totalMoney${stt}"></td>
            </tr>`

        $('.add-row').closest('table').children('#add-row').append(content);
        count++;
        setProduct(stt);
        console.log(count);
    }

    function setProduct(stt) {
        $(`#nameProduct${stt}`).text(JSON.parse($(`select[name="product[${stt}][code]"]`).val()).name + ' ' + $(`select[name="product[${stt}][type]"]`).val());
        setPrice(stt);
        setTotalMoney(stt);
    }

    function setPrice(stt) {
        // Giá
        $(`#price${stt}`).val(JSON.parse($(`select[name="product[${stt}][code]"]`).val()).import_prince);
    }

    function setTotalMoney(stt) {
        // Thành tiền
        $(`#totalMoney${stt}`).text($(`input[name="product[${stt}][number]"]`).val() * $(`input[name="product[${stt}][price]"]`).val());
        setTotal(count);
    }

    function setTotal(count) {
        // Tổng cộng
        let total = 0;
        let amount = 0;
        for (let i = 0; i <= count; i++) {
            let price = $(`input[name="product[${i}][number]"]`).val() * $(`input[name="product[${i}][price]"]`).val();
            total += price;
            amount += Number($(`input[name="product[${i}][number]"]`).val());
        }
        $('#total').text(total);
        $('#amount').text(amount);
    }
</script>
@endsection