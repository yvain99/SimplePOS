<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {

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
            'login-username' => 'required',
            'login-pass' => 'required'
        ];
    }

    public function messages() {
        return [
            'login-username.required' => 'Username Must Be Filled Out!',
            'login-pass.required' => 'Password Must Be Filled Out!'
        ];
    }

}
