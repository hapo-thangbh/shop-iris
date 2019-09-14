@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="w-100 my-3" action="{{ route('add.store_transport') }}" method="POST">
                @csrf
                <input required name="name" class="form-control col-10 col-md-3 my-1" placeholder="Đơn vị vận chuyển">
                <button type="submit" class="btn btn-danger">Thêm</button>
            </form>
        </div>
        <div class="row">
            <div class="{{ session('msg') ? 'alert alert-success w-100' : '' }}">{{ session('msg') ? session('msg') : '' }}</div>
            <div class="{{ session('delete_notice_success') ? 'alert alert-success w-100' : '' }}">
                {{ session('delete_notice_success') ? session('delete_notice_success') : '' }}
            </div>
            <div class="{{ session('delete_notice_failed') ? 'alert alert-danger w-100' : '' }}">
                {{ session('delete_notice_failed') ? session('delete_notice_failed') : '' }}
            </div>
            <table class="table table-bordered table-hover col-12">
                <thead class="bg-danger text-white">
                <tr>
                    <th>STT</th>
                    <th>Hãng vận chuyển</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = 1; ?>
                @foreach($transports as $transport)
                    <tr>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $transport->name }}</td>
                        <td class="text-center">
                            <form action="{{ route('setting.transport.destroy', $transport->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-25" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection



