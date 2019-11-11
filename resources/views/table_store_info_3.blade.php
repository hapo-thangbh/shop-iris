@foreach($reportOrderSources['orderSources'] as $orderSource)
    @php($waitSend2 = $reportOrderSources['waitSend']->where('order_source_id', $orderSource->id))
    @php($send2 = $reportOrderSources['send']->where('order_source_id', $orderSource->id))
    @php($successSend2 = $reportOrderSources['successSend']->where('order_source_id', $orderSource->id))
    @php($fail2 = $reportOrderSources['fail']->where('order_source_id', $orderSource->id))
    <div class="col-3">
        <table class="table table-borderless bg-danger">
            <tr>
                <td class="align-middle font-weight-bold" rowspan="4">{{ $orderSource->name }}</td>
                <td class="font-italic">Chờ gửi</td>
                <td class="text-center" id="revenuesWaitSend">{{ number_format($waitSend2->sum('total') + $waitSend2->sum('ship_fee') - $waitSend2->sum('discount')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Đã gửi</td>
                <td class="text-center" id="revenuesSend">{{ number_format($send2->sum('total') + $send2->sum('ship_fee') - $send2->sum('discount')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn thành</td>
                <td class="text-center" id="revenuesSuccessSend">{{ number_format($successSend2->sum('total') + $successSend2->sum('ship_fee') - $successSend2->sum('discount')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn</td>
                <td class="text-center" id="importPriceSuccessSend">{{ number_format($fail2->sum('total') + $fail2->sum('ship_fee') - $fail2->sum('discount')) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-3">
        <table class="table table-borderless bg-danger">
            <tr>
                <td class="align-middle font-weight-bold" rowspan="4">ĐƠN HÀNG</td>
                <td class="font-italic">Chờ gửi</td>
                <td class="text-center" id="ordersWaitSend">{{ number_format($waitSend2->count()) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Đã gửi</td>
                <td class="text-center" id="ordersSend">{{ number_format($send2->count()) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn thành</td>
                <td class="text-center" id="ordersSuccessSend">{{ number_format($successSend2->count()) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn</td>
                <td class="text-center" id="importPriceSuccessSend">{{ number_format($fail2->count()) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-3">
        <table class="table table-borderless bg-danger">
            <tr>
                <td class="align-middle font-weight-bold" rowspan="4">GIÁ VỐN</td>
                <td class="font-italic">Chờ gửi</td>
                <td class="text-center" id="importPriceWaitSend">{{ number_format($waitSend2->sum('sum_import_price')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Đã gửi</td>
                <td class="text-center" id="importPriceSend">{{ number_format($send2->sum('sum_import_price')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn thành</td>
                <td class="text-center" id="importPriceSuccessSend">{{ number_format($successSend2->sum('sum_import_price')) }}</td>
            </tr>
            <tr>
                <td class="font-italic">Hoàn</td>
                <td class="text-center" id="importPriceSuccessSend">{{ number_format($fail2->sum('sum_import_price')) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-3 rounded" style="height: 104px; overflow-y: scroll; ">
        <table class="table table-borderless text-white" style="background-color: orange">
            @foreach ($provinces as $province)
                <tr>
                    <td class="border-bottom border-danger">{{ $province->name }}</td>
                    <td class="text-center border-danger border-bottom">
                        {{ number_format($send2->where('province_id', $province->id)->sum('total') + $send2->where('province_id', $province->id)->sum('ship_fee') - $send2->where('province_id', $province->id)->sum('discount') + $successSend2->where('province_id', $province->id)->sum('total') + $successSend2->where('province_id', $province->id)->sum('ship_fee') - $successSend2->where('province_id', $province->id)->sum('discount')) }}
                    </td>
                    <td class="text-center border-danger border-bottom">
                        {{ number_format($send2->where('province_id', $province->id)->count() + $send2->where('province_id', $province->id)->count() - $send2->where('province_id', $province->id)->count() + $successSend2->where('province_id', $province->id)->count() + $successSend2->where('province_id', $province->id)->count() - $successSend2->where('province_id', $province->id)->count()) }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endforeach
