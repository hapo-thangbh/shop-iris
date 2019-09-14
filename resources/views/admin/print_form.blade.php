<!DOCTYPE html>
<html lang="vi">
<head>
    <title>In hóa đơn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>@page { size: A5 }</style>
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>
<body class="A5">
<div class="container-fluid mt-3">
    <button class="btn btn-danger px-5" id="btnPrint">In</button>
</div>

<div class="container-fluid mt-2" id="outprint">
    <div class="row">
        <div class="col-12 font-weight-bold" style="font-size: 26px;">{{ $shop->name }}</div>
        <div class="col-6 font-weight-bold">{{ $shop->address }}</div>
        <div class="col-6 text-right"><a href="">{{ $shop->facebook }}</a></div>
        <div class="col-6 font-weight-bold">{{ $shop->phone }}</div>
        <div class="col-6 text-right"><a href="">{{ $shop->shoppe }}</a></div>
    </div>
    <div class="row">
        <div class="col-12 font-weight-bold text-center mt-3 mb-3" style="font-size: 26px;">ĐƠN HÀNG</div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-5 font-weight-bold">Khách hàng:</div>
        <div class="col-lg-7 col-md-6 col-sm-5 col-7">{{ $order->customer->name }}</div>

        <div class="col-lg-1 col-md-2 col-sm-2 col-5">Ngày:</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-7">{{ $order->created_at->format('d/m/Y') }}</div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-5 font-weight-bold">Địa chỉ:</div>
        <div class="col-lg-10 col-md-9 col-sm-9 col-7">{{ $order->customer->address }}</div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-5 font-weight-bold">Điện thoại:</div>
        <div class="col-lg-10 col-md-9 col-sm-9 col-7">{{ $order->customer->phone }}</div>

        <div class="col-12 table-responsive mt-3">
            <table class="table table-bordered">
                <tr class="text-center">
                    <th class="p-1">STT</th>
                    <th class="p-1">Mã</th>
                    <th class="p-1">Tên sản phẩm</th>
                    <th class="p-1">SL</th>
                    <th class="p-1">Đơn giá</th>
                    <th class="p-1">Thành tiền</th>
                </tr>
                <?php $stt=1 ?>
                @foreach($order->orderProducts as $orderProduct)
                    <tr>
                        <td class="text-center font-weight-bold p-1">{{ $stt++ }}</td>
                        <td class=" p-1">{{ $orderProduct->product->code . $orderProduct->type->code }}</td>
                        <td class=" p-1">{{ $orderProduct->product->name . $orderProduct->type->name }}</td>
                        <td class="text-center p-1">{{ $orderProduct->number }}</td>
                        <td class="text-center p-1">{{ number_format($orderProduct->product->export_prince) }}</td>
                        <td class="text-center p-1">{{ number_format($orderProduct->product->export_prince * $orderProduct->number) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="font-italic p-1">Cộng tiền hàng:</td>
                    <td class="text-center p-1">{{ number_format($order->total) }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="font-italic p-1">Chiết khấu:</td>
                    <td class="text-center p-1">{{ number_format($order->discount) }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="font-italic p-1">Phí vận chuyển:</td>
                    <td class="text-center p-1">{{ number_format($order->ship_fee) }}</td>
                </tr>
                <tr>
                    <th colspan="5" class="font-weight-bold p-1">Tổng cộng:</th>
                    <td class="text-center p-1">
                        {{ number_format($order->total + $order->ship_fee - $order->discount) }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <p class="font-weight-bold font-italic mt-3">{{ $shop->note_1 }}</p>
            <p class="font-italic">
                {{ $shop->note_2 }}
            </p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $('#btnPrint').click(function () {
        $(this).addClass('d-none');
        window.print();
    });
</script>
</body>
</html>
