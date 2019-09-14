<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'account' => 'required|unique:users,account|max:255',
            'password' => 'required|max:16',
            'password_confirm' => 'required|same:password|max:16',
            'address' => 'required|max:255',
            'phone' => 'required|max:11',
            'email' => 'email|required|max:255|unique:users,email'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên tài khoản',
            'account' => 'Tài khoản',
            'password' => 'Mật khẩu',
            'password_confirm' => 'Nhập lại mật khẩu',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'email' => 'Email'
        ];
    }
}
