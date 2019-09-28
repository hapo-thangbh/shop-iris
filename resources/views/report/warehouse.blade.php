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
                        <tbody>
                        <tr class="text-center border-bottom border-danger">
                            <td rowspan="{{ $product->productSuppliers->count() }}" class="text-center font-weight-bold">{{ $stt++ }}</td>
                            <td rowspan="{{ $product->productSuppliers->count() }}"><img style="width: 100px; height: auto" src="{{ asset('storage/' . $product->image) }}"></td>
                            <td rowspan="{{ $product->productSuppliers->count() }}">{{ $product->code }}</td>
                            <td rowspan="{{ $product->productSuppliers->count() }}">{{ $product->name }}</td>
                            @if(auth()->user()->level == 1)
                            <td rowspan="{{ $product->productSuppliers->count() }}" class="text-center">{{ number_format($product->import_prince) }}</td>
                            @endif
                            <td rowspan="{{ $product->productSuppliers->count() }}" class="text-center">{{ number_format($product->export_prince) }}</td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                    {{ $product->productSuppliers->first()->type->code }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $product->productSuppliers->first()->type->name }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $product->productSuppliers->first()->total_import - $product->productSuppliers->first()->total_export }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $product->productSuppliers->first()->total_export }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($product->productSuppliers->count())
                                {{ $product->productSuppliers->first()->total_wait_send }}
                                @endif
                            </td>
                            @if(auth()->user()->level == 1)
                            <td rowspan="{{ $product->productSuppliers->count() }}" class="align-mid"><button type="button" class="btn btn-danger" onclick="editProduct({{ $product }}, {{ $categories }})">Sửa</button></td>
                            @endif
                        </tr>
                        <?php $check = 0 ?>
                        <?php $checkCode = [] ?>
                        @foreach ($product->productSuppliers->unique('type_id') as $productSupplier)
                            @if($check)
                                <tr class="border-bottom border-danger text-center">
                                    <td>
                                        {{ $productSupplier->type->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $productSupplier->type->name }}
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
                                        <td>Thuộc tính</td>
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
        function editProduct(product, categories) {
            console.log(product);
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
            var product_suppliers = product.product_suppliers;
            for (var i = 0; i < product_suppliers.length; i++) {
                attribute += `
                    <tr>
                        <td>
                            <input required type="text" class="form-control mb-2" name="attribute_code[]" value="${product_suppliers[i].type.code}">
                        </td>
                        <td>
                            <input required type="text" class="form-control mb-2" name="attribute_name[]" value="${product_suppliers[i].type.name}">
                        </td>
                    </tr>
                `;
            }
            $(`#attribute`).html(attribute);


            $('#edit').modal('show');
        }
        let stt = 0;
        function addOrder() {
            stt++;
            let text = `
                <tr>
                    <td>
                        <input required type="text" class="form-control mb-2" name="attribute_code[]" value="">
                    </td>
                    <td>
                        <input required type="text" class="form-control mb-2" name="attribute_name[]" value="">
                    </td>
                </tr>
            `;
            $('#attribute').append(text);
            // setProduct(stt);
            // $(".select2").select2({ 
            // });
        }
    </script>
@endsection
