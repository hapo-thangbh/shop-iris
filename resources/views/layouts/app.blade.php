<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titlePage }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/thanh.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">
    @guest
    @else
    <nav class="main-header navbar navbar-expand bg-danger navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right bg-danger" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 h-100 bg-danger">
        <!-- Brand Logo -->
        <h3 class="brand-text font-weight-light text-white ml-3 mt-2">IRIS</h3>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @if(auth()->user()->level == 1)
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('index') }}">Trang chủ</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white @if(strpos(request()->url(), '/add/product')) active @endif" href="{{ route('add.product') }}">Sản phẩm</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-white @if(strpos(request()->url(), '/report/order')) active @endif" href ="{{ route('report.order') }}">Đơn hàng</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white @if(strpos(request()->url(), '/report/warehouse')) active @endif" href="{{ route('report.warehouse') }}">Kho hàng</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white @if(strpos(request()->url(), '/report/customer')) active @endif" href="{{ route('report.customer') }}">Khách hàng</a>
                    </li>
                    @if(auth()->user()->level == 1)
                        <li class="nav-item">
                            <a class="nav-link text-white @if(strpos(request()->url(), '/product/import')) active @endif" href="{{ route('product.import') }}">Nhập Hàng</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white @if(
                            strpos(request()->url(), '/shop-info') ||
                            strpos(request()->url(), '/add/type-product') ||
                            strpos(request()->url(), '/add/category') ||
                            strpos(request()->url(), '/add/status-product') ||
                            strpos(request()->url(), '/add/order-source') ||
                            strpos(request()->url(), '/add/type-customer') ||
                            strpos(request()->url(), '/add/status-order') ||
                            strpos(request()->url(), '/add/transport') ||
                            strpos(request()->url(), '/setting/province') ||
                            strpos(request()->url(), '/add/district') ||
                            strpos(request()->url(), '/setting/supplier') ||
                            strpos(request()->url(), '/add/type-order')
                            ) active @endif"
                               href="#"
                               data-toggle="dropdown">
                                Cài đặt
                            </a>
                            <div class="dropdown-menu bg-danger">
                                <a class="dropdown-item text-danger" href="{{ route('shop_info') }}">Thông tin cửa hàng</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.type_product') }}">Loại Sản Phẩm</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.category') }}">Danh Mục Sản Phẩm</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.status_product') }}">Tình Trạng Sản Phẩm</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.order_source') }}">Nguồn Đơn Bán Hàng</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.type_customer') }}">Loại Khách Hàng</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.type_order') }}">Loại Đơn Hàng</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.status_order') }}">Trạng Thái Đơn Hàng</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.transport') }}">Đơn Vị Vận Chuyển</a>
                                <a class="dropdown-item text-danger" href="{{ route('setting.province.index') }}">Tỉnh</a>
                                <a class="dropdown-item text-danger" href="{{ route('add.district') }}">Quận, Huyện</a>
                                <a class="dropdown-item text-danger" href="{{ route('setting.supplier.index') }}">Nhà cung cấp</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(strpos(request()->url(), '/user-management')) active @endif" href="{{ route('user_management') }}">Quản lý người dùng</a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @endguest
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="{{ asset('/js/admin-lte.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}" defer></script>
<script src="{{ asset('js/thanh.js') }}" defer></script>
<script>
    document.body.style.zoom = "80%";
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@yield("script")
</body>
</html>
