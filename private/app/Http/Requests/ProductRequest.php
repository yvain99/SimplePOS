<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'product-image' => 'image|mimes:jpg,png,gif,jpeg|max:2048',
            'product-sku' => 'required',
            'product-name' => 'required',
            'product-pprice' => 'required',
            'product-rprice' => 'required',
            'product-stock' => 'required',
            'product-alert-qty' => 'required'
        ];
    }

    public function messages() {
        return [
            'product-image.mimes' => 'Invalid Image Extension!',
            'product-image.max' => 'Size of Image Must Be < 2MB!',
            'product-sku.required' => 'Product SKU Must Be Filled Out!',
            'product-name.required' => 'Product Name Must Be Filled Out!',
            'product-pprice.required' => 'Product Purchase Price Must Be Filled Out!',
            'product-rprice.required' => 'Product Retail Price Must Be Filled Out!',
            'product-stock.required' => 'Product Stock Must Be Filled Out!',
            'product-alert-qty.required' => 'Product Alert Quantity Must Be Filled Out!'
        ];
    }

}
