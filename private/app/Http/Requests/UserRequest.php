<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

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
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages() {
        return [
            'username.required' => 'Username Must Be Filled Out!',
            'password.required' => 'Password Must Be Filled Out!',
            'name.required' => 'Name Must Be Filled Out!',
            'email.required' => 'Email Must Be Filled Out!',
            'phone.required' => 'Phone Must Be Filled Out!',
        ];
    }

}
