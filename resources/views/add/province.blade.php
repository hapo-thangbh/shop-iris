@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h4 class="w-100">{{ $titlePage }}</h4><br>
                <div class="{{ session('msg') ? 'alert alert-success w-100' : '' }}">
                    {{ session('msg') ? session('msg') : '' }}
                </div>
                <div class="{{ session('delete_notice_success') ? 'alert alert-success w-100' : '' }}">
                    {{ session('delete_notice_success') ? session('delete_notice_success') : '' }}
                </div>
                <div class="{{ session('delete_notice_failed') ? 'alert alert-danger w-100' : '' }}">
                    {{ session('delete_notice_failed') ? session('delete_notice_failed') : '' }}
                </div>
            <form action="{!! route('setting.province.store') !!}" method="POST" class="form-inline w-100 my-3">
                @csrf
                <input required class="form-control w-25 mr-3" name="name" placeholder="Tên tỉnh">
                <button class="btn btn-danger">Thêm</button>
            </form>
            <table class="table table-bordered table-hover">
                <thead class="bg-danger text-white">
                <tr>
                    <th>STT</th>
                    <th>Tỉnh</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = 1 ?>
                @foreach($provinces as $province)
                    <tr>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $province->name }}</td>
                        <td class="text-center">
                            <form action="{{ route('setting.province.destroy', $province->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-25" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $provinces->links() }}
        </div>
    </div>
@endsection


