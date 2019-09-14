@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="#" method="post" class="w-100">
            <div class="row justify-content-between">
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <h1 class="title mb-3">Thêm sản phẩm</h1>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Chọn ảnh</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="file" class="form-control-file" id="" name="txtImage">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Mã sản phẩm *</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="text" class="form-control" id="" name="txtProduct-code">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Tên sản phẩm *</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="text" class="form-control" id="" name="txtProduct-name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Chọn danh mục</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <select class="form-control" id="" name="slCate">
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Giá nhập</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="number" class="form-control" id="" name="txtPrice-import">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Giá bán</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="number" class="form-control" id="" name="txtPrice">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Đơn vị tính</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <input type="text" class="form-control" id="" name="txtUnit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-4 col-md-3 col-sm-3 col-12 col-form-label">Nhà cung cấp</label>
                        <div class="col-lg-8 col-md-9 col-sm-9 col-12">
                            <select class="form-control" id="" name="txtSupplier">
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <button type="button" class="btn btn-danger w-100">Lưu</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <button type="button" class="btn btn-danger w-100">Lưu và thêm mới</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 product-baby">
                    <h1 class="title mb-3">Sản phẩm con</h1>
                    <table class="table table-bordered">
                        <tr>
                            <th>Thuộc tính</th>
                            <th>Mã thuộc tính</th>
                            <th>Tên thuộc tính</th>
                        </tr>
                        <tr>
                            <td>Màu đen Size 35</td>
                            <td>BT01D35</td>
                            <td>Giày nữ màu đen Size 35</td>
                        </tr>
                        <tr>
                            <td>Màu đen Size 35</td>
                            <td>BT01D35</td>
                            <td>Giày nữ màu đen Size 35</td>
                        </tr>
                        <tr>
                            <td>Màu đen Size 35</td>
                            <td>BT01D35</td>
                            <td>Giày nữ màu đen Size 35</td>
                        </tr>
                    </table>
                </div>
            </div>
            @yield('table')
        </form>
    </div>
@endsection

