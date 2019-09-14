@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form action="#" method="post" class="w-100">
            <div class="row my-3">
                <div class="col-6">
                    <h1 class="title  bg-danger text-white pl-2 py-1">DANH SÁCH TÀI KHOẢN</h1>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col-4">
                    <a href="{{ route('add.user') }}" class="btn btn-danger">+ Thêm tài khoản</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="{{ session('msg') ? 'alert alert-success' : '' }}">
                        {{ session('msg') ? session('msg') : '' }}
                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-bordered shadow">
                        <tr class="text-center bg-danger text-white">
                            <th>STT</th>
                            <th>Tên đăng nhập</th>
                            <th>Tên người dùng</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Phân quyền</th>
                            <th>Hành động</th>
                        </tr>
                        <?php $stt = 1; ?>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $stt++ }}</td>
                                <td>{{ $user->account }}
                                    <i style="cursor: pointer" class="fa fa-user-alt" data-toggle="modal" data-target="#pw{{ $user->id }}"></i>
                                    <div class="modal" id="pw{{ $user->id }}">
                                        <form method="POST" action="{{ route('user.update') }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Thay đổi mật khẩu tài khoản {{ $user->account }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Mật khẩu mới:
                                                        <input required type="text" name="password" class="form-control">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">{{ $user->phone }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->address }}</td>
                                <td>{{ $user->level == 1 ? 'ADMIN' : 'EMPLOYEE' }}
                                    <i style="cursor: pointer" class="fa fa-pencil-alt" data-toggle="modal" data-target="#user{{ $user->id }}"></i>
                                    <div class="modal" id="user{{ $user->id }}">
                                        <form method="POST" action="{{ route('user.update') }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Thay đổi quyền tài khoản {{ $user->account }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <select class="form-control" name="level">
                                                            <option value="1" {{ ($user->level == 1) ? 'selected' : '' }}>ADMIN</option>
                                                            <option value="2" {{ ($user->level == 2) ? 'selected' : '' }}>EMPLOYEE</option>
                                                        </select>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    @if($user->is_active == 1)
                                        <form action="{{ route('disable_user', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" {{ $user->level == 1 ? 'disabled' : '' }}
                                            class="btn btn-danger float-left">DISABLE</button>
                                        </form>
                                    @else
                                        <form action="{{ route('active_user', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary float-left">ACTIVE</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

