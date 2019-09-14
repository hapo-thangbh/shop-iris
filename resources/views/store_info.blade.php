@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="#" method="post" class="w-100">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="title mb-3">Thông tin cửa hàng</h1>
                </div>
            </div>
            <div class="row">
                <form class="col-12 table-responsive" action="{{ route('update_shop_info') }}" method="POST">
                    @csrf
                    <div class="{{ session('message') ? 'alert alert-success w-100' : ''  }}">
                        {{ session('message') ? session('message') : ''  }}
                    </div>

                    <div class="{{ $errors->first() ? 'alert alert-danger w-100' : ''  }}">
                        {{ $errors ? $errors->first() : ''  }}
                    </div>

                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th class="align-mid">Tên cửa hàng</th>
                            <td><input type="text" name="name" value="{{ $shop->name }}" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Địa chỉ</th>
                            <td><input type="text" name="address" value="{{ $shop->address }}" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Điện thoại</th>
                            <td><input type="text" name="phone" value="{{ $shop->phone }}" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Facebook</th>
                            <td><input type="text" name="facebook" value="{{ $shop->facebook }}" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Shoppe</th>
                            <td><input type="text" name="shoppe" value="{{ $shop->shoppe }}" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Ghi chú 1</th>
                            <td>
                                <textarea name="note_1" id="" cols="30" rows="3" class="form-control">{{ $shop->note_1 }}</textarea>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <th class="align-mid">Ghi chú 2</th>
                            <td>
                                <textarea name="note_2" id="" cols="30" rows="3" class="form-control">{{ $shop->note_2 }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center"><button type="submit" class="btn btn-danger w-25">Lưu Thay Đổi</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            @yield('table')
        </form>
    </div>
@endsection

