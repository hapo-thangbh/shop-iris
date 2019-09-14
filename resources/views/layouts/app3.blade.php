<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $titlePage }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/thanh.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="app">
    @guest
    @else
        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel bg-danger">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        @if(auth()->user()->level == 1)
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('report.store_sale') }}">Trang chủ</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('add.product') }}">Sản phẩm</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('report.order') }}">Đơn hàng</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('report.warehouse') }}">Kho hàng</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('report.customer') }}">Khách hàng</a>
                        </li>
                        @if(auth()->user()->level === \App\User::ADMIN)
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('product.import') }}">Nhập Hàng</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" data-toggle="dropdown">
                                    Cài đặt
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('shop_info') }}">Thông tin cửa hàng</a>
                                    <a class="dropdown-item" href="{{ route('add.type_product') }}">Loại Sản Phẩm</a>
                                    <a class="dropdown-item" href="{{ route('add.category') }}">Danh Mục Sản Phẩm</a>
                                    <a class="dropdown-item" href="{{ route('add.status_product') }}">Tình Trạng Sản Phẩm</a>
                                    <a class="dropdown-item" href="{{ route('add.order_source') }}">Nguồn Đơn Bán Hàng</a>
                                    <a class="dropdown-item" href="{{ route('add.type_customer') }}">Loại Khách Hàng</a>
                                    <a class="dropdown-item" href="{{ route('add.type_order') }}">Loại Đơn Hàng</a>
                                    <a class="dropdown-item" href="{{ route('add.status_order') }}">Trạng Thái Đơn Hàng</a>
                                    <a class="dropdown-item" href="{{ route('add.transport') }}">Đơn Vị Vận Chuyển</a>
                                    <a class="dropdown-item" href="{{ route('setting.province.index') }}">Tỉnh</a>
                                    <a class="dropdown-item" href="{{ route('add.district') }}">Quận, Huyện</a>
                                    <a class="dropdown-item" href="{{ route('setting.supplier.index') }}">Nhà cung cấp</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('user_management') }}">Quản lý người dùng</a>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endguest
    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}" defer></script>
<script src="{{ asset('js/thanh.js') }}" defer></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@yield('script')
</body>
</html>
