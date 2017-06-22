<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use Redirect;
use Input;

class PurchaseController extends Controller {

    public function holdClosePurchase() {
        $purchase = array(
            'id' => Input::get('id'),
            'productId' => Input::get('productId'),
            'productQty' => Input::get('productQty'),
            'productPrice' => Input::get('productPrice'),
            'productType' => Input::get('productType'),
            'productSupplier' => Input::get('productSupplier'),
            'total' => Input::get('total'),
            'status' => Input::get('status'),
        );

        Purchase::holdClosePurchase($purchase);
        echo "success";
    }

}
