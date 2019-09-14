@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form class="w-100 my-3" action="{{ route('add.store_type_product') }}" method="POST">
                @csrf
                <input name="code" required class="form-control col-6 col-md-2 my-1" placeholder="Mã">
                <input name="name" required class="form-control col-10 col-md-3 my-1" placeholder="Tên loại sản phẩm">
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
                    <th class="text-center">STT</th>
                    <th class="text-center">Mã</th>
                    <th class="text-center">Loại sản phẩm</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = 1; ?>
                @foreach($types as $type)
                    <tr>
                        <td class="text-center">{{ $stt++ }}</td>
                        <td>{{ $type->code }}</td>
                        <td>{{ $type->name }}</td>
                        <td class="text-center">
                            <form action="{{ route('setting.types.destroy', $type->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-12">
                {{ $types->links() }}
            </div>
        </div>
    </div>
@endsection



