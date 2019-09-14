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
            <form action="{!! route('setting.district.store') !!}" method="POST" class="w-100 my-3">
                @csrf
                <select class="form-control w-25 my-1" name="province_id">
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                <input required class="form-control w-25 my-1" placeholder="Quận, huyện" name="name">
                <button class="btn btn-danger">Thêm</button>
            </form>
            <table class="table table-bordered table-hover">
                <thead class="bg-danger text-white">
                <tr>
                    <th>STT</th>
                    <th>Tên quận, huyện</th>
                    <th>Tỉnh</th>
                    <th class="text-center">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = 1 ?>
                @foreach($districts as $district)
                    <tr>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $district->name }}</td>
                        <td>{{ $district->province->name }}</td>
                        <td class="text-center">
                            <form action="{{ route('setting.district.destroy', $district->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-25" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $districts->links() }}
        </div>
    </div>
@endsection


