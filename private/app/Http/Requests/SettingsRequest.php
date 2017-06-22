<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest {

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
            'settings-name' => 'required',
            'settings-address' => 'required',
            'settings-phone' => 'required',
            'settings-receipt-text' => 'required'
        ];
    }

    public function messages() {
        return [
            'settings-name.required' => 'Company Name Must Be Filled Out!',
            'settings-address.required' => 'Company Address Must Be Filled Out!',
            'settings-phone.required' => 'Company Phone Must Be Filled Out!',
            'settings-receipt-text.required' => 'Receipt Text Must Be Filled Out!'
        ];
    }

}
