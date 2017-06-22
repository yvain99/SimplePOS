<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use Redirect;
use Input;

class SalesController extends Controller {

    public function holdCloseSales() {
        $sales = array(
            'id' => Input::get('id'),
            'productId' => Input::get('productId'),
            'productQty' => Input::get('productQty'),
            'productPrice' => Input::get('productPrice'),
            'customerUsername' => Input::get('customerUsername'),
            'discount' => Input::get('discount'),
            'tax' => Input::get('tax'),
            'subTotal' => Input::get('subTotal'),
            'total' => Input::get('total'),
            'paymentMethod' => Input::get('paymentMethod'),
            'paymentMethodNumber' => Input::get('paymentMethodNumber'),
            'description' => Input::get('description'),
            'status' => Input::get('status'),
        );

        Sales::holdCloseSales($sales);
        echo "success";
    }

    public function holdCloseEditSales() {
        $sales = array(
            'id' => Input::get('id'),
            'productId' => Input::get('productId'),
            'productQty' => Input::get('productQty'),
            'productPrice' => Input::get('productPrice'),
            'customerUsername' => Input::get('customerUsername'),
            'discount' => Input::get('discount'),
            'tax' => Input::get('tax'),
            'subTotal' => Input::get('subTotal'),
            'total' => Input::get('total'),
            'paymentMethod' => Input::get('paymentMethod'),
            'paymentMethodNumber' => Input::get('paymentMethodNumber'),
            'description' => Input::get('description'),
            'status' => Input::get('status'),
            'oldProductId' => Input::get('oldProductId'),
            'oldProductQty' => Input::get('oldProductQty')
        );
        
        Sales::holdCloseEditSales($sales);
        echo "success";
    }

}
