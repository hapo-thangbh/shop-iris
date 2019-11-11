@extends('layouts.app')

@section('content')
    <div class="container-fluid text-white">
        <div class="row">
            <div class="col-3 offset-9 text-right">
                <a class="btn btn-danger m-1" href="{{ route('product.export') }}">+ Bán hàng</a>
            </div>
        </div>
        <div class="row mb-3 mt-3">
            <div class="col-6 title font-weight-bold ">
                <div class="bg-danger pl-2">BÁO CÁO TỔNG HỢP</div>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="" name="start_date" onchange="getValueReport()" value="{{ date('Y-m-01') }}">
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="" name="end_date" onchange="getValueReport()" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="row" id="table2">
            @include('table_store_info_2')
        </div>

        <div class="row mb-3 mt-3">
            <div class="col-6 title font-weight-bold ">
                <div class="bg-danger pl-2">NGUỒN ĐƠN</div>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="" name="start_date_2" onchange="getValueReport3()" value="{{ date('Y-m-01') }}">
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="" name="end_date_2" onchange="getValueReport3()" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="row" id="table3">
            @include('table_store_info_3', [
                'reportOrderSources' => $reportOrderSources,
                'provinces' => $provinces
            ])
        </div>

        <div class="row mt-5 mb-3">
            <div class="col-6 title font-weight-bold">
                <div class="bg-danger pl-2">KHO HÀNG</div>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="" name="time" onchange="getValueReport2()" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="row" id="table">
            @include('table_store_info')
        </div>
    </div>
@endsection

@section('script')
<script>
    function getValueReport() {
        let startDate = $('input[name=start_date]').val();
        let endDate = $('input[name=end_date]').val();

        $.ajax({
            url: "{{ route('report.store_sale_ajax') }}",
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
            },
            success: function (respon) {
                $('#table2').html(respon);
            },
            errors: function () {
                alert('Lỗi server!!! Vui lòng reload trang.')
            }
        })
    }

    function getValueReport3() {
        let startDate = $('input[name=start_date_2]').val();
        let endDate = $('input[name=end_date_2]').val();

        $.ajax({
            url: "{{ route('report.store_sale_ajax_3') }}",
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
            },
            success: function (respon) {
                $('#table3').html(respon);
            },
            errors: function () {
                alert('Lỗi server!!! Vui lòng reload trang.')
            }
        })
    }

    function getValueReport2() {
        let time = $('input[name=time]').val();
        $.ajax({
            url: "{{ route('report.store_sale_ajax2') }}",
            method: 'GET',
            data: {
                time: time,
            },
            success: function (respon) {
                $('#table').html(respon);
            },
            errors: function () {
                alert('Lỗi server!!! Vui lòng reload trang.')
            }
        })
    }
</script>
@endsection
