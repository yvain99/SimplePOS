<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IngredientRequest;
use App\Ingredient;
use DB;
use Redirect;
use Input;

class IngredientController extends Controller {

    public function addNewIngredient(IngredientRequest $request) {
        $name = Input::get('ingredient-name');
        $qty = Input::get('ingredient-qty');
        $alertqty = Input::get('ingredient-alert-qty');
        $pprice = Input::get('ingredient-pprice');
        $unit = Input::get('ingredient-unit');
        
        Ingredient::addNewIngredient($name, $qty, $alertqty, $pprice, $unit);
        return Redirect::to('ingredients_add')->with('successIngredient', 'Ingredient has been added!');
    }

    public function editIngredient(IngredientRequest $request) {
        $id = Input::get('ingredient-id');
        $name = Input::get('ingredient-name');
        $qty = Input::get('ingredient-qty');
        $alertqty = Input::get('ingredient-alert-qty');
        $pprice = Input::get('ingredient-pprice');
        $unit = Input::get('ingredient-unit');
        
        Ingredient::editIngredient($id, $name, $qty, $alertqty, $pprice, $unit);
        return Redirect::to('ingredients_edit/' . $id)->with('successIngredient', 'Ingredient has been edited!');
    }

    public function removeIngredient() {
        $id = Input::get('id');
        $result = Ingredient::removeIngredient($id);
        
        if ($result)
            echo "success";
        else
            echo "error";
    }

}
