<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="{{ asset('css/thanh.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class=" col-12 col-md-6 col-lg-5 col-xl-4">
            <div class="card">
                <h6 class="card-header w-100 text-center bg-danger text-white font-weight-bold">ĐĂNG NHẬP</h6>
                <div class="text-center text-danger mt-3">{{ $errors ? $errors->first() : '' }} {{ session('msg') ? session('msg') : '' }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-12 col-form-label text-center">TÊN ĐĂNG NHẬP</label>

                            <div class="col-md-12">
                                <input id="account" type="text" class="text-center form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="account" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-12 col-form-label text-center">MẬT KHẨU</label>

                            <div class="col-md-12">
                                <input required id="password" type="password" class="text-center form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                            </div>
                        </div>
                        <br>


                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger w-100">
                                    ĐĂNG NHẬP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
