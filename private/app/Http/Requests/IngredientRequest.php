<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest {

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
            'ingredient-name' => 'required',
            'ingredient-pprice' => 'required',
            'ingredient-qty' => 'required',
            'ingredient-alert-qty' => 'required'
        ];
    }

    public function messages() {
        return [
            'ingredient-name.required' => 'Ingredient Name Must Be Filled Out!',
            'ingredient-pprice.required' => 'Ingredient Purchase Price Must Be Filled Out!',
            'ingredient-qty.required' => 'Ingredient Quantity Must Be Filled Out!',
            'ingredient-alert-qty.required' => 'Ingredient Alert Quantity Must Be Filled Out!'
        ];
    }

}
