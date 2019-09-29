<div class="col-3">
    <table class="table table-borderless bg-danger">
        <tr>
            <td class="align-middle font-weight-bold" rowspan="4">DOANH THU</td>
            <td class="font-italic">Chờ gửi</td>
            <td class="text-center" id="revenuesWaitSend">{{ number_format($revenues['waitSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Đã gửi</td>
            <td class="text-center" id="revenuesSend">{{ number_format($revenues['send']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn thành</td>
            <td class="text-center" id="revenuesSuccessSend">{{ number_format($revenues['successSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn</td>
            <td class="text-center" id="importPriceSuccessSend">{{ number_format($revenues['fail']) }}</td>
        </tr>
    </table>
</div>
<div class="col-3">
    <table class="table table-borderless bg-danger">
        <tr>
            <td class="align-middle font-weight-bold" rowspan="4">ĐƠN HÀNG</td>
            <td class="font-italic">Chờ gửi</td>
            <td class="text-center" id="ordersWaitSend">{{ number_format($orders['waitSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Đã gửi</td>
            <td class="text-center" id="ordersSend">{{ number_format($orders['send']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn thành</td>
            <td class="text-center" id="ordersSuccessSend">{{ number_format($orders['successSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn</td>
            <td class="text-center" id="importPriceSuccessSend">{{ number_format($orders['fail']) }}</td>
        </tr>
    </table>
</div>
<div class="col-3">
    <table class="table table-borderless bg-danger">
        <tr>
            <td class="align-middle font-weight-bold" rowspan="4">GIÁ VỐN</td>
            <td class="font-italic">Chờ gửi</td>
            <td class="text-center" id="importPriceWaitSend">{{ number_format($importPrice['waitSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Đã gửi</td>
            <td class="text-center" id="importPriceSend">{{ number_format($importPrice['send']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn thành</td>
            <td class="text-center" id="importPriceSuccessSend">{{ number_format($importPrice['successSend']) }}</td>
        </tr>
        <tr>
            <td class="font-italic">Hoàn</td>
            <td class="text-center" id="importPriceSuccessSend">{{ number_format($importPrice['fail']) }}</td>
        </tr>
    </table>
</div>
<div class="col-3">
    <table class="table table-borderless bg-danger h-75">
        <tr>
            <td class="align-middle font-weight-bold" rowspan="3">NHẬP HÀNG</td>
            <td class="align-middle text-center" rowspan="3" id="totalImport">{{ number_format($totalImport) }}</td>
        </tr>
    </table>
</div>
