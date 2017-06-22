<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class Product extends Model {

    protected $table = 'product';
    public $primarykey = 'id';
    public $timestamps = false;

    public static function getProductCategories() {
        $categories = DB::table('product_category')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

        return $categories;
    }

    public static function addProductCategory($name) {
        if (User::checkToken(session('username'), session('token'))) {
            DB::table('product_category')
                    ->insert(['name' => $name]);
            return true;
        } else
            return false;
    }

    public static function removeProductCategory($id) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                DB::table('product_category')
                        ->where('id', '=', $id)
                        ->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function getProductUnits() {
        $units = DB::table('unit_type')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

        return $units;
    }

    public static function removeProductUnit($id) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                DB::table('unit_type')
                        ->where('id', '=', $id)
                        ->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function addProductUnit($name) {
        if (User::checkToken(session('username'), session('token'))) {
            DB::table('unit_type')
                    ->insert(['name' => $name]);
            return true;
        } else
            return false;
    }

    public static function getProducts($offset, $sv, $sc) {
        if (is_null($sv) && is_null($sc)) {
            $products = Product::select('product.*', 'product_category.name AS category_name')
                            ->join('product_category', 'product.category', '=', 'product_category.id')
                            ->orderBy('product.sku')
                            ->offset($offset)->limit(10)->get();
        } else {
            $products = Product::select('product.*', 'product_category.name AS category_name')
                            ->join('product_category', 'product.category', '=', 'product_category.id')
                            ->where($sc, 'like', '%' . $sv . '%')
                            ->orderBy('product.sku')
                            ->offset($offset)->limit(10)->get();
        }
        return $products;
    }

    public static function getProductData($id) {
        $product = Product::find($id);
        return $product;
    }

    public static function getSalesAddProducts($category) {
        $products = Product::select('id', 'image', 'name', 'retail_price', 'stock', 'ingredients')
                ->where('category', '=', $category)
                ->orderBy('name')
                ->get();

        $productsArr = array();
        foreach ($products as $product) {
            if ($product['ingredients'] == "Yes") {
                $productIngredients = Product::getProductIngredients($product['id']);
                $stock = true;
                $qtyArr = array();

                if (count($productIngredients) > 0) {
                    foreach ($productIngredients as $productIngredient) {
                        $phiQty = $productIngredient->qty;
                        $iQty = $productIngredient->ingredient_qty;

                        if ($iQty < $phiQty) {
                            $stock = false;
                            break;
                        } else
                            $qtyArr[] = floor($iQty / $phiQty);
                    }
                } else
                    $stock = false;

                if ($stock)
                    $stock = min($qtyArr);
                else
                    $stock = '-1';
            } else {
                if ($product['stock'] == "0")
                    $stock = '-1';
                else
                    $stock = $product['stock'];
            }

            $productsArr[] = array(
                'id' => $product['id'],
                'image' => $product['image'],
                'name' => $product['name'],
                'retail_price' => $product['retail_price'],
                'stock' => $stock
            );
        }

        return $productsArr;
    }

    public static function getProductIngredients($id) {
        $productIngredients = DB::table('product_has_ingredient AS phi')
                ->select('phi.id AS id', 'phi.ingredient_id AS ingredient_id', 'phi.qty AS qty', 'i.name AS ingredient_name', 'i.qty AS ingredient_qty', 'u.name AS unit_name')
                ->join('ingredient AS i', 'phi.ingredient_id', '=', 'i.id')
                ->join('unit_type AS u', 'i.unit', '=', 'u.id')
                ->where('phi.product_id', '=', $id)
                ->orderBy('i.name')
                ->get();
        return $productIngredients;
    }

    public static function addNewProduct($image, $sku, $name, $pprice, $rprice, $stock, $alertqty, $ingredients, $category) {
        if (User::checkToken(session('username'), session('token'))) {
            $product = new Product;
            $product->image = $image;
            $product->sku = $sku;
            $product->name = $name;
            $product->purchase_price = $pprice;
            $product->retail_price = $rprice;
            $product->stock = $stock;
            $product->alert_qty = $alertqty;
            $product->ingredients = $ingredients;
            $product->category = $category;

            $product->save();
            return true;
        } else
            return false;
    }

    public static function editProduct($id, $image, $sku, $name, $pprice, $rprice, $stock, $alertqty, $category) {
        if (User::checkToken(session('username'), session('token'))) {
            $product = Product::find($id);
            $product->image = $image;
            $product->sku = $sku;
            $product->name = $name;
            $product->purchase_price = $pprice;
            $product->retail_price = $rprice;
            $product->stock = $stock;
            $product->alert_qty = $alertqty;
            $product->category = $category;

            $product->save();
        }
    }

    public static function editProductIngredients($product_id, $ingredient_id, $qty) {
        if (User::checkToken(session('username'), session('token'))) {
            DB::table('product_has_ingredient')
                    ->where('product_id', '=', $product_id)
                    ->delete();

            if (count($ingredient_id) > 0) {
                $phi = array();
                for ($i = 0; $i < count($ingredient_id); $i++) {
                    $phi[] = array(
                        'product_id' => $product_id,
                        'ingredient_id' => $ingredient_id[$i],
                        'qty' => $qty[$i]
                    );
                }
                DB::table('product_has_ingredient')->insert($phi);
            }
        }
    }

    public static function removeProduct($id) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $product = Product::find($id);

                $image = $product->image;
                if ($image)
                    File::delete('img/product/' . $image);

                $product->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function getPurchaseIngredients($sv) {
        $result = DB::table('ingredient AS i')
                ->select('i.*', 'i.qty AS stock', 'ut.name AS unit_type')
                ->join('unit_type AS ut', 'i.unit', '=', 'ut.id')
                ->where('i.name', 'like', '%' . $sv . '%')
                ->orderBy('i.name')
                ->get();
        return $result;
    }

    public static function getPurchaseProducts($sv) {
        $result = Product::where([
                    ['name', 'like', '%' . $sv . '%'],
                    ['ingredients', '=', 'No']
                ])
                ->orderBy('name')
                ->get();
        return $result;
    }

    public static function generateProductsReport($startDate, $endDate, $category) {
        $report = DB::table('sales_has_product AS shp')
                ->selectRaw('SUM(shp.qty) AS sold_qty, SUM((shp.price - (shp.price * s.discount / 100)) * shp.qty) AS sold_price, p.sku AS sku, p.name AS name')
                ->join('sales AS s', 'shp.sales_id', '=', 's.id')
                ->join('product AS p', 'shp.product_id', '=', 'p.id')
                ->whereBetween('shp.created', [$startDate, $endDate])
                ->groupBy('shp.product_id')
                ->orderBy($category, 'DESC')
                ->get();

        return $report;
    }

    public static function countProducts() {
        $count = Product::selectRaw('COUNT(id) AS total')->get();
        return $count[0]->total;
    }

    public static function getProductIngredientsAlert() {
        $products = Product::select('name', 'stock AS qty')
                ->whereRaw('stock < alert_qty')
                ->get();

        $ingredients = DB::table('ingredient AS i')
                ->select('i.name AS name', 'i.qty AS qty', 'ut.name AS unit_name')
                ->join('unit_type AS ut', 'i.unit', '=', 'ut.id')
                ->whereRaw('qty < alert_qty')
                ->get();

        $result = array(
            'products' => $products,
            'ingredients' => $ingredients
        );

        return $result;
    }

}
