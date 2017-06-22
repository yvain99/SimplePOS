<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\ProductUnitRequest;
use App\Http\Requests\ProductRequest;
use App\Product;
use DB;
use Redirect;
use Input;
use Image;
use File;

class ProductController extends Controller {

    public function addProductCategory(ProductCategoryRequest $request) {
        $name = Input::get('product-category-name');

        Product::addProductCategory($name);
        return Redirect::to('categories')->with('successCategory', 'Data has been added');
    }

    public function removeProductcategory() {
        $id = Input::get('id');
        $result = Product::removeProductCategory($id);

        if ($result)
            echo "success";
        else
            echo "error";
    }

    public function addProductUnit(ProductUnitRequest $request) {
        $name = Input::get('product-unit-name');

        Product::addProductUnit(Input::get('product-unit-name'));
        return Redirect::to('categories')->with('successUnit', 'Data has been added');
    }

    public function removeProductUnit() {
        $id = Input::get('id');
        $result = Product::removeProductUnit($id);

        if ($result)
            echo "success";
        else
            echo "error";
    }

    public function addNewProduct(ProductRequest $request) {
        if ($request->hasFile('product-image')) {
            $image = Input::get('product-sku') . "." . $request->file('product-image')->getClientOriginalExtension();
            $size = getimagesize($request->file('product-image'));
            $request->file('product-image')->move('img/product', $image);

            if ($size[0] > 800) {
                $resizeImg = Image::make('img/product/' . $image);
                $resizeImg->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
        } else
            $image = null;

        $sku = Input::get('product-sku');
        $name = Input::get('product-name');
        $pprice = Input::get('product-pprice');
        $rprice = Input::get('product-rprice');
        $stock = Input::get('product-stock');
        $alertqty = Input::get('product-alert-qty');
        $ingredients = (Input::get('product-ingredients')) ? "Yes" : "No";
        $category = Input::get('product-category');

        Product::addNewProduct($image, $sku, $name, $pprice, $rprice, $stock, $alertqty, $ingredients, $category);
        return Redirect::to('products_add')->with('successProduct', 'Product has been added!');
    }

    public function editProduct(ProductRequest $request) {
        $id = Input::get('product-id');
        $imageOld = (Input::get('product-image-old')) ? 'img/product/' . Input::get('product-image-old') : null;

        if ($request->hasFile('product-image')) {
            $image = Input::get('product-sku') . "." . $request->file('product-image')->getClientOriginalExtension();
            $size = getimagesize($request->file('product-image'));

            if (!is_null($imageOld)) {
                File::delete($imageOld);
                $request->file('product-image')->move('img/product', $image);
            } else {
                $request->file('product-image')->move('img/product', $image);
            }

            if ($size[0] > 800) {
                $resizeImg = Image::make('img/product/' . $image);
                $resizeImg->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
        } else
            $image = Input::get('product-image-old');

        $sku = Input::get('product-sku');
        $name = Input::get('product-name');
        $pprice = Input::get('product-pprice');
        $rprice = Input::get('product-rprice');
        $stock = Input::get('product-stock');
        $alertqty = Input::get('product-alert-qty');
        $category = Input::get('product-category');

        Product::editProduct($id, $image, $sku, $name, $pprice, $rprice, $stock, $alertqty, $category);
        return Redirect::to('products_edit/' . $id)->with('successProduct', 'Product has been edited!');
    }

    public function removeProduct() {
        $id = Input::get('id');
        $result = Product::removeProduct($id);

        if ($result)
            echo "success";
        else
            echo "error";
    }
    
    public function editProductIngredients(){
        $product_id = Input::get('product-id');
        $ingredient_id = Input::get('ingredient-id');
        $qty = Input::get('ingredient-qty');
        
        Product::editProductIngredients($product_id, $ingredient_id, $qty);
        return Redirect::to('products_edit/' . $product_id . '/ingredients')->with('successProductIngredients', 'Product ingredients has been edited!');
    }

}
