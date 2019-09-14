@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="{{ session('msg') ? 'alert alert-success w-100' : '' }}">{{ session('msg') ? session('msg') : '' }}</div>
            <div class="{{ session('delete_notice_success') ? 'alert alert-success w-100' : '' }}">
                {{ session('delete_notice_success') ? session('delete_notice_success') : '' }}
            </div>
            <div class="{{ session('delete_notice_failed') ? 'alert alert-danger w-100' : '' }}">
                {{ session('delete_notice_failed') ? session('delete_notice_failed') : '' }}
            </div>
            <form class="w-100 my-3" action="{{ route('add.store_status_order') }}" method="POST">
                @csrf
                <input name="name" required class="form-control col-10 col-md-3 my-1" placeholder="Tình trạng">
                <button type="submit" class="btn btn-danger">Thêm</button>
            </form>
        </div>
        <div class="row">
            <table class="table table-bordered table-hover col-12">
                <thead class="bg-danger text-white">
                <tr>
                    <th>STT</th>
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
                            <form action="{{ route('setting.delete_status_order', $status->id) }}" method="POST" class="d-inline">
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



