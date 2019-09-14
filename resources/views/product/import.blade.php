@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="title mb-3 d-inline-block">Tổng hợp nhập hàng</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-3 mb-3">
                <a class="btn btn-danger" href="{{ route('report.import_product') }}">+ Nhập hàng</a>
            </div>

            <div class="col-3 offset-6 text-right">
                <a class="btn btn-danger m-1" href="{{ route('product.export') }}">+ Bán hàng</a>
            </div>
        </div>
        <form action="{{ route('product.import') }}" method="GET" class="row">
            <div class="col-2">
                <input type="text" class="form-control" name="code" placeholder="Mã hàng">
            </div>

            <div class="col-2">
                <select name="supplier_id" class="form-control select2">
                    <option value="">Nhà Cung Cấp (Tất cả)</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-2">
                <input type="date" class="form-control" name="fromDate" value="{{ date('Y-m-01') }}">
            </div>

            <div class="col-2">
                <input type="date" class="form-control" name="toDate" value="{{ date('Y-m-d') }}">
            </div>

            <div class="col-2">
                <button class="btn btn-danger">Tìm kiếm</button>
            </div>
        </form>
        <div class="row mt-3">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <tr class="text-center bg-danger text-white">
                        <th>STT</th>
                        <th>Ngày nhập</th>
                        <th>Mã</th>
                        <th>Tên sản phẩm</th>
                        <th>Nhà cung cấp</th>
                        <th>Số lượng</th>
                        <th>Giá nhận</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php $stt = 1; ?>
                    @foreach ($product_suppliers as $product)
                    <tr>
                        <td class="text-center font-weight-bold">{{ $stt++ }}</td>
                        <td class="text-center">{{ date_format($product->created_at, "d/m/Y") }}</td>
                        <td>{{ $product->product->code }}</td>
                        <td>{{ $product->product->name }} {{ $product->type->name }}</td>
                        <td>{{ $product->supplier->name }}</td>
                        <td class="text-center" id="number{{ $stt }}">{{ $product->number }}</td>
                        <td class="text-center" id="price{{ $stt }}">{{ $product->price }}</td>
                        <td class="text-center" id="totalMoney{{ $stt }}">{{ $product->number * $product->price }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="7" class="text-center">Tổng cộng</th>
                        <td class="text-center" id="total">{{ $total }}</td>
                    </tr>
                </table>
                {{ $product_suppliers
                ->appends([
                    'code' => $request->code,
                    'supplier' => $request->supplier,
                    'fromDate' => $request->fromDate,
                    'toDate' => $request->toDate,
                ])
                ->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        let total = 0;
        for (let i = 2; i <= <?= $stt ?>; i++) {
            $(`#totalMoney${i}`).text($(`#number${i}`).text() * $(`#price${i}`).text());
            total += Number($(`#totalMoney${i}`).text());
        }
        $('#total').text(total);
    });
</script>
@endsection
