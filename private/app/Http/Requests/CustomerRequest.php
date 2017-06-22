<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest {

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
            'customer-username' => 'required',
            'customer-password' => 'required',
            'customer-name' => 'required',
            'customer-email' => 'required',
            'customer-phone' => 'required'
        ];
    }

    public function messages() {
        return [
            'customer-username.required' => 'Username Must Be Filled Out!',
            'customer-password.required' => 'Password Must Be Filled Out!',
            'customer-name.required' => 'Name Must Be Filled Out!',
            'customer-email.required' => 'Email Must Be Filled Out!',
            'customer-phone.required' => 'Phone Must Be Filled Out!'
        ];
    }

}
