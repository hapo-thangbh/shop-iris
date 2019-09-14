@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="{{ session('msg') ? 'alert alert-success w-100' : '' }}">{{ session('msg') ? session('msg') : '' }}</div>
        <div class="{{ session('delete_notice_success') ? 'alert alert-success w-100' : '' }}">
            {{ session('delete_notice_success') ? session('delete_notice_success') : '' }}
        </div>
        <div class="{{ session('delete_notice_failed') ? 'alert alert-danger w-100' : '' }}">
            {{ session('delete_notice_failed') ? session('delete_notice_failed') : '' }}
        </div>
        <form class="w-100 my-3" action="{{ route('add.store_status_product') }}" method="POST">
            @csrf
            <div class="row align-items-center">
                <div class="col-3">
                    <input name="name" required type="text" class="form-control my-1" placeholder="Tình trạng">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-danger w-75">Thêm</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-hover col-12">
            <thead class="bg-danger text-white">
            <tr>
                <th class="text-center">STT</th>
                <th>Tình trạng</th>
                <th class="text-center">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php $stt = 1; ?>
            @foreach($statuses as $status)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $status->name }}</td>
                    <td class="text-center">
                        <form action="{{ route('setting.status.destroy', $status->id) }}" method="POST" class="d-inline">
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
@endsection



