@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h4 class="col-12">{{ $titlePage }}</h4>
        </div>
        <div class="row">
            <form class="form-inline col-12 my-5" action="{{ route('add.store_category') }}" method="POST">
                @csrf
                <h5>Tên danh mục:</h5>
                <input required class="form-control w-50 mx-3" name="name">
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
                    <th>Tên danh mục</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = 1; ?>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <form action="{{ route('setting.category.destroy', $category->id) }}" method="POST" class="d-inline">
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


