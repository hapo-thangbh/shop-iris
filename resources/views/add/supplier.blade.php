@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
			<h4 class="w-100">{{ $titlePage }}</h4><br>
            @if(session('notification'))
                <div class="alert alert-success w-100">
                    {{ session('notification') }}
                </div>
            @endif
            <div class="{{ session('delete_notice_success') ? 'alert alert-success w-100' : '' }}">
                {{ session('delete_notice_success') ? session('delete_notice_success') : '' }}
            </div>
            <div class="{{ session('delete_notice_failed') ? 'alert alert-danger w-100' : '' }}">
                {{ session('delete_notice_failed') ? session('delete_notice_failed') : '' }}
            </div>
            <form action="{!! route('setting.supplier.store') !!}" method="POST" class="form-inline w-100 my-3">
                @csrf
                <input class="form-control w-25 mr-3" name="name" type='text' placeholder="Tên NCC" required>
                <input class="form-control w-25 mr-3" name="address" type='text' placeholder="Địa chỉ" required>
                <input class="form-control w-25 mr-3" name="phone" type='number' placeholder="Số điện thoại" required>
                <button class="btn btn-danger">Thêm</button>
            </form>
            <table class="table table-bordered table-hover">
                <thead class="bg-danger text-white">
                <tr>
                    <th>STT</th>
                    <th>Tên NCC</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                	<?php $stt = 1 ?>
                	@foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td class="text-center">
                            <form action="{{ route('setting.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
