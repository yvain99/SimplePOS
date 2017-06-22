@extends('template/home')
@section('title', 'Point Of Sales - Purchase Complete Preview')
@section('content')

<div id="purchase-print-element" class="purchase-print-preview-element">
    <div class="purchase-preview-header center-align">
        <div class="company-name" style="font-size:2em;"></div>
        <div class="company-address"></div>
        <div>Phone: <span class="company-phone"></span></div>
    </div>
    <div class="divider" style="margin:10px 0 10px 0;"></div>
    <div style="line-height:2;">
        <div><b>Purchase ID:</b> #{{$purchase[0]->id}}</div>
        <div><b>Created: </b> {{date('m/d/Y, h:i:s A', strtotime($purchase[0]->created))}}</div>
    </div>
    <div class="divider" style="margin:10px 0 10px 0;"></div>
    <div class="purchase-preview-body">
        <table width="100%">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Supplier</th>
                    <th>Name</th>
                    <th>Each</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = explode("||", $purchase[0]->products);
                $productIds = explode(",", $products[0]);
                $productSuppliers = explode(",", $products[1]);
                $productSupplierNames = explode(",", $products[2]);
                $productQtys = explode(",", $products[3]);
                $productPrices = explode(",", $products[4]);
                $productTypes = explode(",", $products[5]);
                $productNames = explode(",", $products[6]);
                $ingredientNames = explode(",", $products[7]);

                for ($i = 0; $i < count($productIds); $i++) {
                    if ($productTypes[$i] == "0")
                        $productName = $ingredientNames[$i];
                    else
                        $productName = $productNames[$i];
                    ?>
                    <tr>
                        <td>{{$productQtys[$i]}}</td>
                        <td>{{$productSupplierNames[$i]}}</td>
                        <td>{{$productName}}</td>
                        <td>{{number_format($productPrices[$i])}}</td>
                        <td>{{number_format($productQtys[$i] * $productPrices[$i])}}</td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="divider"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:right;">
                        <b>Grand Total:</b> {{number_format($purchase[0]->total)}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="padding:10px;text-align:center;">
    <div class="purchase-print-btn" ng-click="printPurchase()">
        <i class="fa fa-print fa-lg"></i> Print
    </div>
</div>

@stop
