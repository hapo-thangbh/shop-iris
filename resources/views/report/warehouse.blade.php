@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-2 offset-10 text-right">
                <a class="btn btn-danger m-1" href="{{ route('product.export') }}">+ Bán hàng</a>
            </div>
        </div>
        <form action="{{ route('report.warehouse') }}" method="GET" class="row my-3 form-inline">
            <div class="mx-1">
                <input type="text" class="form-control" id="" name="code_search" placeholder="Mã hàng">
            </div>

            <div class="mx-1">
                <input type="text" class="form-control" id="" name="name_search" placeholder="Tên sản phẩm">
            </div>

            <div class="mx-1">
                <select class="form-control select2" id="" name="category_search">
                    <option value="">Loại sản phẩm (tất cả)</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mx-1">
                <select class="form-control select2" id="" name="supplier_search">
                    <option value="">Nhà cung cấp (tất cả)</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mx-1">
                <input type="date" class="form-control" id="" name="start_date_search">
            </div>

            <div class="mx-1">
                <input type="date" class="form-control" id="" name="end_date_search">
            </div>

            <div class="mx-1">
                <button type="submit" class="btn btn-danger">Tìm kiếm</button>
            </div>
        </form>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-borderless">
                    <tr class="text-center bg-danger text-white">
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Mã</th>
                        <th>Tên sản phẩm</th>
                        @if(auth()->user()->level == 1)
                        <th>Giá vốn</th>
                        @endif
                        <th>Giá bán</th>
                        <th>Thuộc tính</th>
                        <th>Tên thuộc tính</th>
                        <th>Tồn</th>
                        <th>Đã bán</th>
                        <th>Chờ gửi</th>
                        @if(auth()->user()->level == 1)
                        <th>Sửa</th>
                        @endif
                    </tr>
                    <?php $stt = 1; ?>
                    @foreach ($products as $product)
                        @php($rowSpan = $product->productSuppliers->count() + 1)
                        <tbody>
                        <tr class="border-bottom border-danger">
                            <td rowspan="{{ $rowSpan }}" class="text-center font-weight-bold">{{ $stt++ }}</td>
                            <td class="text-center" rowspan="{{ $rowSpan }}"><img style="width: 100px; height: auto" src="{{ asset('storage/' . $product->image) }}"></td>
                            <td class="text-center" rowspan="{{ $rowSpan }}">{{ $product->code }}</td>
                            <td rowspan="{{ $rowSpan }}">{{ $product->name }}</td>
                            @if(auth()->user()->level == 1)
                            <td rowspan="{{ $rowSpan }}" class="text-center">{{ number_format($product->import_prince) }}</td>
                            @endif
                            <td rowspan="{{ $rowSpan }}" class="text-center">{{ number_format($product->export_prince) }}</td>
                            @php($productSupplierFirst = $product->productSuppliers->sortBy('type_code')->first())
                            <td>
                                @if($product->productSuppliers->count())
                                    {{ $productSupplierFirst->type_code }}
                                @endif
                            </td>
                            <td>
                                @if($product->productSuppliers->count())
                                {{ $productSupplierFirst->type_name }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $productSupplierFirst->total_import - $productSupplierFirst->total_export }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $productSupplierFirst->total_export }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $productSupplierFirst->total_wait_send }}
                                @endif
                            </td>
                            @if(auth()->user()->level == 1)
                            <td rowspan="{{ $rowSpan }}" class="text-center align-mid"><button type="button" class="btn btn-danger" onclick="editProduct({{ $product }}, {{ $categories }}, {{ $product->productSuppliers->unique('type_id') }}, {{ $typeProducts }})">Sửa</button></td>
                            @endif
                        </tr>
                        <?php $check = 0 ?>
                        <?php $checkCode = [] ?>
                        @php($total1 = 0)
                        @php($total2 = 0)
                        @php($total3 = 0)
                        @foreach ($product->productSuppliers->unique('type_id')->sortBy('type_code') as $productSupplier)
                            @php($total1 += $productSupplier->total_import - $productSupplier->total_export)
                            @php($total2 += $productSupplier->total_export)
                            @php($total3 += $productSupplier->total_wait_send)
                            @if($check)
                                <tr class="border-bottom border-danger">
                                    <td>
                                        {{ $productSupplier->type_code }}
                                    </td>
                                    <td>
                                        {{ $productSupplier->type_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $productSupplier->total_import - $productSupplier->total_export }}
                                    </td>
                                    <td class="text-center">
                                        {{ $productSupplier->total_export }}
                                    </td>
                                    <td class="text-center">
                                        {{ $productSupplier->total_wait_send }}
                                    </td>
                                </tr>
                            @endif
                            <?php $check++ ?>
                        @endforeach
                        <tr class="border-bottom border-danger">
                            <td>

                            </td>
                            <td class="text-red">
                                Tổng
                            </td>
                            <td class="text-center text-red">
                                {{ $total1 }}
                            </td>
                            <td class="text-center text-red">
                                {{ $total2 }}
                            </td>
                            <td class="text-center text-red">
                                {{ $total3 }}
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            <div class="col-12">{{ $products->appends([
                'code_search' => $request->code_search,
                'name_search' => $request->name_search,
                'category_search' => $request->category_search,
                'supplier_search' => $request->supplier_search,
                'start_date_search' => $request->start_date_search,
                'end_date_search' => $request->end_date_search
                ])->links() }}</div>
        </div>
    </div>
    <!-- </div> -->
    <!-- The Modal -->
    <div class="modal fade" id="edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="post" id="formUpdate" enctype="multipart/form-data">
                <!-- Modal body -->
                <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Ảnh</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" name="image">
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Mã</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" id="" name="code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tên SP</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" id="" name="name">
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Danh mục</label>
                            <div class="col-sm-9" id="category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Giá vốn</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" id="" name="import_prince">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Giá bán</label>
                            <div class="col-sm-9">
                                <input required type="number" min="0" class="form-control" id="" name="export_prince">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Các thuộc tính</label>
                            <div class="col-sm-9">{{-- id="attribute" --}}
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Mã thuộc tính</td>
                                        <td>Tên thuộc tính</td>
                                    </tr>
                                    <tbody id="attribute">

                                    </tbody>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button type="button" class="btn btn-danger" onclick="addOrder()">+</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Lưu thay đổi</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let stt = 0;
        function editProduct(product, categories, productSuppliers, typeProducts) {
            $(".select2").select2({});
            $('#formUpdate').attr('action', `/product/update/${product.id}`);
            $('input[name=import_prince]').val(product.import_prince);
            $('input[name=export_prince]').val(product.export_prince);
            $('input[name=code]').val(product.code);
            $('input[name=name]').val(product.name);
            // danh mục
            var option = '';
            for (var i = 0; i < categories.length; i++) {
                option += `
                    <option data-id="${categories[i].id}" value="${categories[i].id}">${categories[i].name}</option>
                `;
            }
            var text = `
                <select class="form-control" name="category_id">`+
                    option
                +`</select>
            `;
            $(`#category`).html(text);
            $(`option[data-id=${product.category_id}]`).attr('selected', 'selected');




            // thuộc tính
            var attribute = '';
            var option = '';
            // Convert object to array
            var productSuppliers = $.map(productSuppliers, function(value, index) {
                return [value];
            });


            for (var i = 0; i < productSuppliers.length; i++) {
                $.each( typeProducts, function( key, typeProduct ) {
                    var selected = '';
                    if (productSuppliers[i].type.id == typeProduct.id) {
                        var selected = 'selected';
                    }
                    option += `
                        <option ${selected} value="${typeProduct.id}">${typeProduct.code}</option>
                    `;
                });

                attribute += `
                    <tr>
                        <td>
                            <select class="form-control select2" name="attribute_code[${stt++}]" onchange="setType(${stt-1});">
                                ${option}
                            </select>
                        </td>
                        <td id="inputTypeName${stt-1}" class="align-middle">
                            ${productSuppliers[i].type.name}
                        </td>
                    </tr>
                `;
                option = '';
            }

            $(`#attribute`).html(attribute);
            $(".select2").select2({});




            $('#edit').modal('show');
        }



        function setType(id) {
            let code = $(`select[name="attribute_code[${id}]"]`).val();
            if(code) {
                $.ajax({
                    url: "{{ route('product.get_type_name') }}",
                    method: 'GET',
                    data: {
                        id: code,
                    },
                    success: function (respon) {
                        $(`#inputTypeName${id}`).html(respon);
                        $(".select2").select2({
                        });
                    }
                })
            }
        }


        let $typeProducts = JSON.parse('<?= json_encode($typeProducts) ?>');
        function addOrder() {
            let text = `
                <tr>
                <td>
                    <select class="form-control select2" required name="attribute_code[${stt}]" onchange="setType(${stt});">
                        <option value=""></option>
                        @foreach($typeProducts as $typeProduct)
                        <option value="{{ $typeProduct->id }}">{{ $typeProduct->code }}</option>
                        @endforeach
                    </select>
                </td>
                <td id="inputTypeName${stt}" class="align-middle"></td>
            </tr>
            `;
            $('#attribute').append(text);
            stt++;
            $(".select2").select2({});
        }
    </script>
@endsection

