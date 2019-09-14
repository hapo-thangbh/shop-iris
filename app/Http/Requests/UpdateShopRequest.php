<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
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
            'name' => 'required|max:30',
            'address' => 'required|max: 255',
            'phone' => 'required|max:11',
            'note_1' => 'max:255',
            'note_2' => 'max:255',
            'facebook' => 'max:50',
            'shoppe' => 'max:50'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Shop Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'note_1' => 'Note 1',
            'note_2' => 'Note 2',
            'facebook' => 'Facebook',
            'shoppe' => 'Shoppe'
        ];
    }
}
