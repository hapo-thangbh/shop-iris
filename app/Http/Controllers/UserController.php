<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Order;
use App\OrderProduct;
use App\OrderSource;
use App\Product;
use App\ProductSupplier;
use App\Status;
use App\Type;
use App\User;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            $titlePage = "Trang quản trị";
            if (auth()->user()->level == User::ADMIN) {
                $waitSend = Order::whereHas('status', function ($query) {
                    $query->where('name', 'Chờ gửi')->where('type', Status::ORDER);
                })->where('created_at', '>=', date('Y-m-01'));
                $send = Order::whereHas('status', function ($query) {
                    $query->where('name', 'Đã gửi')->where('type', Status::ORDER);
                })->where('created_at', '>=', date('Y-m-01'));
                $successSend = Order::whereHas('status', function ($query) {
                    $query->where('name', 'Hoàn thành')->where('type', Status::ORDER);
                })->where('created_at', '>=', date('Y-m-01'));
                $fail = Order::whereHas('status', function ($query) {
                    $query->where('name', 'Hoàn')->where('type', Status::ORDER);
                })->where('created_at', '>=', date('Y-m-01'));
                $respon = [
                    'titlePage' => 'Doanh thu cửa hàng',
                    'revenues' => [
                        'waitSend' => $waitSend->sum('total') + $waitSend->sum('ship_fee') - $waitSend->sum('discount'),
                        'send' => $send->sum('total') + $send->sum('ship_fee') - $send->sum('discount'),
                        'successSend' => $successSend->sum('total') + $successSend->sum('ship_fee') - $successSend->sum('discount'),
                        'fail' => $fail->sum('total') + $fail->sum('ship_fee') - $fail->sum('discount'),
                    ],
                    'orders' => [
                        'waitSend' => $waitSend->count(),
                        'send' => $send->count(),
                        'successSend' => $successSend->count(),
                        'fail' => $fail->count(),
                    ],
                    'importPrice' => [
                        'waitSend' => $waitSend->get()->sum('sum_import_price'),
                        'send' => $send->get()->sum('sum_import_price'),
                        'successSend' => $successSend->get()->sum('sum_import_price'),
                        'fail' => $fail->get()->sum('sum_import_price'),
                    ],
                    'totalImport' => ProductSupplier::all()->where('created_at', '>=', date('Y-m-01'))->sum('total_import_price'),
                    'totalMoney' => Product::all()->sum('total_money'),
                    'totalNumber' =>  ProductSupplier::all()->sum('number') - OrderProduct::whereHas('order', function($query) {
                            $query ->whereIn('status_id', [2, 3, 5]);
                        })->get()->sum('number'),
                    'reportOrderSources' => [
                        'orderSources' => OrderSource::with('orders.status')->get(),
                        'waitSend' => $waitSend->get(),
                        'send' => $send->get(),
                        'successSend' => $successSend->get(),
                        'fail' => $fail->get(),
                    ],
                    'provinces' => Province::all(),
                ];
                return view('report.store_sale', $respon);
            }
            return redirect()->route('report.order');
        }
        $titlePage = "Đăng nhập";
        return view('login',compact('titlePage'));
    }

    public function login(Request $request)
    {
        if (User::where('account',$request->account)->firstOrFail()->is_active == User::ACTIVE) {
            if (Auth::attempt(['account' => $request->account, 'password' => $request->password])) {
                return redirect()->route('index');
            }
            return redirect()->back()->with('msg', __('messages.errors.login'));
        }
        return redirect()->back()->with('msg', __('messages.errors.active'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    public function management()
    {
        $titlePage = "Quản Lý Tài Khoản";
        $users = User::paginate(10);
        return view('user_management',compact('titlePage', 'users'));
    }

    public function create()
    {
        $titlePage = "Thêm Tài Khoản";
        return view('add.user', compact('titlePage'));
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'account' => $request->account,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'level' => $request->level ? $request->level : User::EMPLOYEE,
        ]);
        return redirect()->route('user_management')->with('msg', __('messages.success.create'));
    }

    public function active($id)
    {
        User::findOrFail($id)->update([
           'is_active' => User::ACTIVE,
        ]);
        return redirect()->back()->with('msg', __('messages.success.active'));
    }

    public function disable($id)
    {
        if (User::findOrFail($id)->level === User::ADMIN) {
            return redirect()->back()->with('msg', __('messages.errors.disable'));
        }
        User::findOrFail($id)->update([
            'is_active' => User::DISABLE,
        ]);
        return redirect()->back()->with('msg', __('messages.success.disable'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($request->level) {
            $user->update($request->all());
            return redirect()->back()->with('msg', 'Thay đổi quyền tài khoản thành công.');
        }
        if ($request->password) {
            $password = Hash::make($request->password);
            $user->update([
                'password' => $password
            ]);
            return redirect()->back()->with('msg', 'Thay đổi mật khẩu thành công.');
        }
    }
}
