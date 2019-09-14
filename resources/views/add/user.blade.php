@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6 shadow pt-3 mt-5">
                <form action="{{ route('add.store_user') }}" method="POST">
                    @csrf
                    <div class="row form-group">
                        <div class="col-12 text-center">
                            <h4>Thông tin tài khoản<h4>
                        </div>
                    </div>

                    <div class="row form-group">
                        @if($errors->first())
                            <div class="alert-danger alert col-12">{{ $errors->first() }}</div>
                        @endif
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="name">Họ & tên</label>
                        </div>
                        <div class="col-8">
                            <input required id="name" name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="account">Tài khoản</label>
                        </div>
                        <div class="col-8">
                            <input required id="account" name="account" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="password">Mật khẩu</label>
                        </div>
                        <div class="col-8">
                            <input required id="password" name="password" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="password_confirm">Nhập lại mật khẩu</label>
                        </div>
                        <div class="col-8">
                            <input required id="password_confirm" name="password_confirm" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-8">
                            <input required id="email" name="email" type="email" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="phone">SDT</label>
                        </div>
                        <div class="col-8">
                            <input required id="phone" name="phone" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="address">Địa chỉ</label>
                        </div>
                        <div class="col-8">
                            <textarea required name="address" id="address" rows="2" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-4">
                            <label for="address">Phân quyền</label>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="level">
                                <option value="2">Nhân viên</option>
                                <option value="1">Quản lý</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group justify-content-center">
                        <div class="col-4">
                            <button type="submit" class="btn btn-danger w-100">Tạo tài khoản</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

