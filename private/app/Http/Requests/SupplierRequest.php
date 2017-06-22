<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest {

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
            'supplier-name' => 'required',
            'supplier-address' => 'required',
            'supplier-phone' => 'required',
            'supplier-email' => 'required'
        ];
    }

    public function messages() {
        return [
            'supplier-name.required' => 'Supplier Name Must Be Filled Out!',
            'supplier-address.required' => 'Supplier Address Must Be Filled Out!',
            'supplier-phone.required' => 'Supplier Phone Must Be Filled Out!',
            'supplier-email.required' => 'Supplier Email Must Be Filled Out!'
        ];
    }

}
