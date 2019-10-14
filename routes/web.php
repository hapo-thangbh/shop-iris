<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('app/public/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});
Route::get('', 'UserController@index')->name('index');
Route::post('login','UserController@login')->name('login');
Route::post('logout','UserController@logout')->name('logout');
Route::prefix('')->middleware('auth')->group(function () {
    Route::get('print/{id}', 'OrderController@printOrder')->name('print_order');
    Route::prefix('add')->name('add.')->group(function () {
        Route::get('district','DistrictController@create')->name('district');
        Route::get('province','ProvinceController@create')->name('province');
        Route::get('category','CategoryController@create')->name('category');
        Route::post('category','CategoryController@store')->name('store_category');
        Route::get('status-order','StatusController@order')->name('status_order');
        Route::post('status-order','StatusController@storeOrder')->name('store_status_order');
        Route::get('status-product','StatusController@product')->name('status_product');
        Route::post('status-product','StatusController@storeProduct')->name('store_status_product');
        Route::get('type-customer','TypeController@customer')->name('type_customer');
        Route::post('type-customer','TypeController@storeCustomer')->name('store_type_customer');
        Route::get('type-order','TypeController@order')->name('type_order');
        Route::post('type-order','TypeController@storeOrder')->name('store_type_order');
        Route::get('type-product','TypeController@product')->name('type_product');
        Route::post('type-product','TypeController@storeProduct')->name('store_type_product');
        Route::get('order-source','OrderSourceController@create')->name('order_source');
        Route::post('order-source','OrderSourceController@store')->name('store_order_source');
        Route::get('transport','TransportController@create')->name('transport');
        Route::post('transport','TransportController@store')->name('store_transport');
        Route::get('product','ProductController@create')->name('product');
        Route::post('product','ProductController@store')->name('store_product');
        Route::get('user','UserController@create')->name('user');
        Route::post('user','UserController@store')->name('store_user');
        Route::get('user/{id}/edit', 'UserController@edit')->name('user.edit');
    });
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('select-type','ProductController@ajaxGetType')->name('get_type');
        Route::get('export','ProductController@export')->name('export');
        Route::get('export/{id}/','ProductController@exportForCustomer')->name('export_for_customer');
        Route::post('export','ProductController@exportStore')->name('store_export');
        Route::get('import','ProductController@import')->name('import');
        Route::post('import-product','ProductController@importProduct')->name('import-product');
        Route::get('search-warehouse','ProductController@searchWarehouse')->name('search-warehouse');
        Route::put('update/{id}','ProductController@update')->name('update');
    });
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::post('edit-address', 'CustomerController@editAddress')->name('edit_address');
        Route::post('info', 'CustomerController@info')->name('info');
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::post('edit-note', 'OrderController@editNote')->name('edit_note');
        Route::post('edit-status', 'OrderController@editStatus')->name('edit_status');
        Route::post('info', 'OrderController@info')->name('info');
        Route::get('edit-order/{id}', 'OrderController@edit_order')->name('edit_order');
        Route::put('order/{id}', 'OrderController@update')->name('update');
    });
    Route::get('shop-info','ShopController@edit')->name('shop_info');
    Route::post('shop-info','ShopController@update')->name('update_shop_info');
    Route::get('user-management','UserController@management')->name('user_management');
    Route::post('user-management','UserController@update')->name('user.update');
    Route::post('active-user/{id}','UserController@active')->name('active_user');
    Route::post('disable-user/{id}','UserController@disable')->name('disable_user');
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('customer','CustomerController@report')->name('customer');
        Route::get('store-sale','ShopController@report')->name('store_sale');
        Route::get('store-sale-ajax','ShopController@reportAjax')->name('store_sale_ajax');
        Route::get('store-sale-ajax2','ShopController@reportAjax2')->name('store_sale_ajax2');
        Route::get('store-sale-ajax_3','ShopController@reportAjax3')->name('store_sale_ajax_3');
        Route::get('warehouse','ProductController@warehouse')->name('warehouse');
        Route::get('import-product','ProductController@reportImport')->name('import_product');
        Route::get('order','OrderController@report')->name('order');
    });
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::resource('province','ProvinceController');
        Route::resource('district','DistrictController');
        Route::resource('supplier','SupplierController');
        Route::resource('types','TypeController');
        Route::resource('category','CategoryController');
        Route::resource('ordersource','OrderSourceController');
        Route::resource('transport','TransportController');
        Route::resource('status','StatusController');
        Route::delete('delete-customer/{id}','TypeController@deleteCustomer')->name('delete_customer');
        Route::delete('delete-order/{id}','TypeController@deleteOrder')->name('delete_order');
        Route::delete('delete-status-order/{id}','StatusController@deleteStatusOrder')->name('delete_status_order');
    });
    Route::prefix('get')->name('get.')->group(function () {
        Route::post('district','ProvinceController@getDistrict')->name('district');
    });
});