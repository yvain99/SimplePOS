@extends('template/home')
@section('title', 'Point Of Sales - Sales Complete Preview')
@section('content')

<div id="sales-print-element" class="sales-print-preview-element">
    <div class="sales-add-header">
        <div class="center-align" style="font-size:2em;">
            <span class="company-name"></span>
        </div>
        <div class="center-align" style="line-height:1.5;font-size:0.8em;padding-bottom:5px;">
            <span class="company-address"></span><br/>
            Phone: <span class="company-phone"></span>
        </div>
        <div class="divider"></div>
        <div style="font-size:0.75em;padding-bottom:5px;">
            <table id="sales-add-table" width="100%">
                <tbody>
                    <tr>
                        <td>{{date('d/m/Y, h:i:s A', strtotime($sales[0]->created))}}</td>
                        <td class="right-align">
                            <input type="hidden" name="sales-id" value="{{$sales[0]->sid}}"/>
                            #<span id="sales-add-id">{{$sales[0]->sid}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>{{session('name')}}</td>
                        <td class="right-align">
                            {{$sales[0]->customer_name}}
                        </td>
                    </tr>
                    <tr id="sales-add-payment-method">
                        <td>
                            //{{$sales[0]->description}}
                        </td>
                        <td class="right-align">
                            {{$sales[0]->payment_method}} {{$sales[0]->payment_method_number}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="divider"></div>
    </div>
    <div class="sales-add-products" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}" style="padding-bottom:10px;">
        <table id="sales-add-products-table" width="100%">
            <thead>
                <tr>
                    <th width="15%">Qty</th>
                    <th>Name</th>
                    <th>Each</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = explode("||", $sales[0]->products);
                $productIds = explode(",", $products[0]);
                $productQtys = explode(",", $products[1]);
                $productPrices = explode(",", $products[2]);
                $productNames = explode(",", $products[3]);

                for ($i = 0; $i < count($productIds); $i++) {
                    ?>
                    <tr id="sales-product-{{$productIds[$i]}}"> 
                        <td>                              
                            <div style="padding-left:8px;">{{$productQtys[$i]}}</div> 
                        </td> 
                        <td>{{$productNames[$i]}}</td> 
                        <td> 
                            {{number_format($productPrices[$i])}} 
                        </td> 
                        <td id="sales-product-{{$productIds[$i]}}-total">
                            {{number_format($productPrices[$i] * $productQtys[$i])}}
                        </td> 
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="sales-add-footer">
        <div class="divider"></div>
        <?php
        $salesDiscount = $sales[0]->subtotal * $sales[0]->discount / 100;
        $salesTax = $sales[0]->subtotal - $salesDiscount;
        $salesTax = $salesTax * $sales[0]->tax / 100;
        ?>
        <table id="sales-add-products-table" width="100%">
            <tbody>
                <tr>
                    <td>
                        <input type="hidden" name="sales-discount" value="[[salesDiscValue]]"/>
                        Disc.: {{number_format($salesDiscount)}} ({{$sales[0]->discount}}%)
                    </td>
                    <td class="right-align">
                        <input type="hidden" name="sales-subtotal" value="[[salesSubtotal]]"/>
                        Sub Total: {{number_format($sales[0]->subtotal)}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="sales-tax" value="[[salesTax]]"/>
                        Tax: {{number_format($salesTax)}} ({{$sales[0]->tax}}%)
                    </td>
                    <td class="right-align">
                        <input type="hidden" name="sales-total" value="[[salesTotal]]"/>
                        <b>Total: {{number_format($sales[0]->total)}}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> 
</div>
<div style="padding:10px;text-align:center;">
    <div class="sales-print-btn" ng-click="printSales()">
        <i class="fa fa-print fa-lg"></i> Print
    </div>
</div>

@stop
