<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Ingredient extends Model {

    protected $table = 'ingredient';
    public $primarykey = 'id';
    public $timestamps = false;

    public static function getIngredients() {
        $ingredients = Ingredient::select('ingredient.*', 'unit_type.name AS unit_name')
                ->join('unit_type', 'ingredient.unit', '=', 'unit_type.id')
                ->orderBy('ingredient.name')
                ->get();
        return $ingredients;
    }

    public static function getIngredientData($id) {
        $ingredient = Ingredient::find($id);
        return $ingredient;
    }

    public static function addNewIngredient($name, $qty, $alertqty, $pprice, $unit) {
        if (User::checkToken(session('username'), session('token'))) {
            $ingredient = new Ingredient;
            $ingredient->name = $name;
            $ingredient->qty = $qty;
            $ingredient->alert_qty = $alertqty;
            $ingredient->purchase_price = $pprice;
            $ingredient->unit = $unit;

            $ingredient->save();
        }
    }

    public static function editIngredient($id, $name, $qty, $alertqty, $pprice, $unit) {
        if (User::checkToken(session('username'), session('token'))) {
            $ingredient = Ingredient::find($id);
            $ingredient->name = $name;
            $ingredient->qty = $qty;
            $ingredient->alert_qty = $alertqty;
            $ingredient->purchase_price = $pprice;
            $ingredient->unit = $unit;

            $ingredient->save();
        }
    }

    public static function removeIngredient($id) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $ingredient = Ingredient::find($id);
                $ingredient->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function countIngredients() {
        $count = Ingredient::selectRaw('COUNT(id) AS total')->get();
        return $count[0]->total;
    }

}
