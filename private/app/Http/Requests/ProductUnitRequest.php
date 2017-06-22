<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUnitRequest extends FormRequest {

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
            'product-unit-name' => 'required'
        ];
    }

    public function messages() {
        return [
            'product-unit-name.required' => 'Unit Name Must Be Filled Out!'
        ];
    }

}
