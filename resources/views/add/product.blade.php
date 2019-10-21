@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-8 text-right">
                <a class="btn btn-danger m-1" href="{{ route('product.export') }}">+ Bán hàng</a>
            </div>
        </div>
        <div class="col-12">
            <div class="{{ session('msg') ? 'alert alert-success' : '' }}">
                {{ session('msg') ? session('msg') : '' }}
            </div>
        </div>
        <form id="formAddProduct" action="{{ route('add.store_product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-5">
                <div class="col-2">
                    <label for="image" class="btn btn-danger w-100">Chọn ảnh ..</label>
                    <input type="file" class="d-none" id="image" required name="image" onchange="previewImage(event)">
                    @if ($errors->has('image'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                    <img class="my-1 w-100 h-auto" id="imagePreview">
                </div>
                <div class="col-5">
                    <table class="w-100">
                        <tr class="w-100">
                            <td class="w-25">Mã sản phẩm <span class="text-danger">*</span></td>
                            <td class="w-50">
                                <input required class="form-control my-1" name="code" value="{{ old('code') }}">
                                @if ($errors->has('code'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tên sản phẩm <span class="text-danger">*</span></td>
                            <td>
                                <input required class="form-control my-1" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Chọn danh mục</td>
                            <td>
                                <select class="form-control my-1 select2" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Giá nhập</td>
                            <td>
                                <input class="form-control my-1" name="import_prince" value="{{ old('import_prince', 0) }}">
                                @if ($errors->has('import_prince'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('import_prince') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Giá bán</td>
                            <td>
                                <input class="form-control my-1" name="export_prince" value="{{ old('export_prince', 0) }}">
                                @if ($errors->has('export_prince'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('export_prince') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Đơn vị tính</td>
                            <td>
                                <input class="form-control my-1" value="VNĐ" name="unit">
                                @if ($errors->has('unit'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('unit') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Nhà cung cấp</td>
                            <td>
                                <select class=" w-100 form-control my-1 select2" name="supplier_id">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-5">
                    <table class="table table-bordered">
                        <tr class="bg-danger">
                            <th class="text-center">STT</th>
                            <th class="text-center">Thuộc tính</th>
                            <th class="text-center">Tên thuộc tính</th>
                            <th class="text-center"></th>
                        </tr>
                        <tbody id="tbody">
                            <tr>
                                <td class="text-center align-middle">1</td>
                                <td>
                                    <select class="form-control select2" name="attr[0]" onchange="getType(0)">
                                        <option value=""></option>
                                        @foreach($types as $type)
                                            <option value="{{ $type }}">{{ $type->code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td id="nameType0" class="align-middle"></td>
                                <td class="text-center"><button type="button" class="btn-del-attr btn bg-danger">Xóa</button></td>
                            </tr>
                        </tbody>
                        <tr>
                            <td class="text-center"><a href="javascript:void(0)" class="btn bg-danger" onclick="addType()">+</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="hidden" id="checkBtn" name="check">
            <div class="row mt-5">
                <button type="button" id="btnSaveFirst" class="btn btn-danger col-3 offset-3">LƯU</button>
                <button type="button" id="btnSaveSecond" class="btn btn-danger col-3 offset-1">LƯU VÀ THÊM MỚI</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#btnSaveFirst').click(function () {
                $('#checkBtn').val(0);
                $('#formAddProduct').submit();
            });
            $('#btnSaveSecond').click(function () {
                $('#checkBtn').val(1);
                $('#formAddProduct').submit();
            });

            $(".btn-del-attr").click(function(){
                $(this).closest('tr').remove();
            });
        });
        function previewImage(event)
        {
            let reader = new FileReader();
            reader.onload = function()
            {
                $('#imagePreview').attr('src', reader.result);
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        var stt = 0;
        function getType(stt)
        {
            if($(`select[name="attr[${stt}]"]`).val()){
                var type = JSON.parse($(`select[name="attr[${stt}]"]`).val());
                $(`#nameType${stt}`).html(`${type.name}`);
            }
        }

        function addType()
        {
            stt++;
            $('#tbody').append(`
                <tr>
                    <td class="text-center">${stt+1}</td>
                    <td>
                        <select class="form-control select2" name="attr[${stt}]" onchange="getType(${stt})">
                            <option value=""></option>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ $type->code }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td id="nameType${stt}" class="align-middle"></td>
                    <td class="text-center"><button type="button" class="btn-del-attr btn bg-danger">Xóa</button></td>
                </tr>
            `);
            $(".select2").select2({});
            getType(stt);
            $(".btn-del-attr").click(function(){
                $(this).closest('tr').remove();
            });
        }
    </script>
@endsection


