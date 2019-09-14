<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'code' => 'unique:products|max:20|required',
            'name' => 'required|max:255',
            'import_prince' => 'nullable|numeric',
            'export_prince' => 'nullable|numeric',
            'unit' => 'nullable|max:255',
            'image' => 'required|mimes:jpg,jpeg,bmp,png|max:5124'
        ];
    }

    public function attributes()
    {
        return [
            'code' => __('title.product.code'),
            'name' => __('title.product.name'),
            'import_prince' => __('title.product.prince.import'),
            'export_prince' => __('title.product.prince.export'),
            'unit' => __('title.product.unit'),
            'image' => __('title.product.image'),
        ];
    }
}
