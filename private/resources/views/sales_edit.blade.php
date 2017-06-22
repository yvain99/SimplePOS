@extends('template/home')
@section('title', 'Point Of Sales - Sales Edit')
@section('content')

<div class="sales-add-content row">
    <div class="col m5 l5 s12 z-depth-1">
        {!! Form::open(['id' => 'add-sales-form', 'url' => 'editSales']) !!}
        <span id="sales-print-element">
            <div class="sales-add-header">
                <div class="center-align" style="font-size:1.5em;">
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
                                <td>{{date('d/m/Y, h:i:s A', time())}}</td>
                                <td class="right-align">
                                    <input type="hidden" name="sales-id" value="{{$sales[0]->sid}}"/>
                                    #<span id="sales-add-id">{{$sales[0]->sid}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>{{session('name')}}</td>
                                <td class="right-align">
                                    <input type="hidden" name="sales-customer" value="[[salesCustomerUsername]]"/>
                                    [[salesCustomer]]
                                </td>
                            </tr>
                            <tr id="sales-add-payment-method">
                                <td>
                                    //{{$sales[0]->description}}
                                </td>
                                <td class="right-align">
                                    <input type="hidden" name="sales-payment-method" value="[[salesPaymentMethod]]"/>
                                    <input type="hidden" name="sales-payment-method-number" value="[[salesPaymentMethodNumber]]"/>
                                    [[salesPaymentMethod]] [[salesPaymentMethodNumber]]
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
            </div>
            <div class="sales-add-products" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
                <table id="sales-add-products-table" width="100%">
                    <tbody>
                        <tr>
                            <td width="15%">Qty</td>
                            <td>Name</td>
                            <td>Each</td>
                            <td>Total</td>
                            <td></td>
                        </tr>
                        <?php
                        $products = explode("||", $sales[0]->products);
                        $productIds = explode(",", $products[0]);
                        $productQtys = explode(",", $products[1]);
                        $productPrices = explode(",", $products[2]);
                        $productNames = explode(",", $products[3]);

                        echo '<tr class="">';
                        echo '<td>';
                        echo '<input id="sales-product-ids" type="hidden" value="' . implode(",", $productIds) . '"/>';
                        echo '<input id="sales-product-qtys" type="hidden" value="' . implode(",", $productQtys) . '"/>';
                        echo '</td>';
                        echo '</tr>';
                        for ($i = 0; $i < count($productIds); $i++) {
                            ?>
                            <tr id="sales-product-{{$productIds[$i]}}"> 
                                <td>                              
                                    <input  
                                        id="sales-product-{{$productIds[$i]}}-qty"  
                                        class="center-align" 
                                        type="hidden"  
                                        name="sales-product-qty[]"  
                                        value="{{$productQtys[$i]}}"/> 
                                    <div style="padding-left:8px;">{{$productQtys[$i]}}</div> 
                                </td> 
                                <td>{{$productNames[$i]}}</td> 
                                <td> 
                                    <input  
                                        id="sales-product-  id  -price"  
                                        class="center-align" 
                                        type="hidden"  
                                        name="sales-product-price[]"  
                                        value="{{$productPrices[$i]}}"/> 
                                    {{number_format($productPrices[$i])}} 
                                </td> 
                                <td id="sales-product-{{$productIds[$i]}}-total">
                                    {{number_format($productPrices[$i] * $productQtys[$i])}}
                                </td> 
                                <td> 
                                    <input  
                                        id="sales-product-{{$productIds[$i]}}-id"  
                                        class="center-align" 
                                        type="hidden"  
                                        name="sales-product-id[]"  
                                        value="{{$productIds[$i]}}"/> 
                                    <div class="sales-add-product-remove-btn"  
                                         ng-click="removeSalesAddProduct('{{$productIds[$i]}}');"> 
                                        <i class="fa fa-times"></i> 
                                    </div> 
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
                <table id="sales-add-products-table" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="sales-discount" value="[[salesDiscValue]]"/>
                                Disc.: [[salesDisc]] ([[salesDiscValue]]%)
                            </td>
                            <td class="right-align">
                                <input type="hidden" name="sales-subtotal" value="[[salesSubtotal]]"/>
                                Sub Total: [[salesSubtotal]]
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="sales-tax" value="[[salesTax]]"/>
                                Tax: [[salesTax]] ([[salesTaxValue]]%)
                            </td>
                            <td class="right-align">
                                <input type="hidden" name="sales-total" value="[[salesTotal]]"/>
                                <b>Total: [[salesTotal]]</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>            
            <input type="hidden" name="sales-description" value="[[salesDescription]]"/>

            <input class="sales-data-temp" id="sales-data-payment-method" type="hidden" value="{{$sales[0]->payment_method}}">
            <input class="sales-data-temp" id="sales-data-payment-method-number" type="hidden" value="{{$sales[0]->payment_method_number}}">
            <input class="sales-data-temp" id="sales-data-customer-username" type="hidden" value="{{$sales[0]->customer}}">
            <input class="sales-data-temp" id="sales-data-customer" type="hidden" value="{{$sales[0]->customer_name}}">
            <input class="sales-data-temp" id="sales-data-subtotal" type="hidden" value="{{$sales[0]->subtotal}}">
            <input class="sales-data-temp" id="sales-data-total" type="hidden" value="{{$sales[0]->total}}">
            <input class="sales-data-temp" id="sales-data-tax-value" type="hidden" value="{{$sales[0]->tax}}">
            <input class="sales-data-temp" id="sales-data-disc-value" type="hidden" value="{{$sales[0]->discount}}">
            <input class="sales-data-temp" id="sales-data-description" type="hidden" value="{{$sales[0]->description}}">
        </span>
        {!! Form::close() !!}
        <span id="sales-edit-identifier" style="display:none;"></span>
        <div class="sales-add-options">
            <div class="divider"></div>
            <div class="sales-add-options-content center-align" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
                <div class="sales-add-option" ng-click="setSalesDiscount()">
                    <i class="fa fa-percent"></i><br/>
                    Set Disc.
                </div>
                <div class="sales-add-option" ng-click="setSalesTax()">
                    <i class="fa fa-percent"></i><br/>
                    Set Tax
                </div>
                <div class="sales-add-option" ng-click="setSalesPaymentMethod()">
                    <i class="fa fa-money"></i><br/>
                    Set Payment Method
                </div>
                <div class="sales-add-option" ng-click="setSalesPaymentMethodNumber()">
                    <i class="fa fa-credit-card"></i><br/>
                    Set Payment Number
                </div>
                <div class="sales-add-option" ng-click="setSalesCustomer()">
                    <i class="fa fa-user"></i><br/>
                    Set Customer
                </div>
                <div class="sales-add-option" ng-click="holdCloseEditSales('Hold')">
                    <i class="fa fa-file"></i><br/>
                    Hold Order
                </div>
                <div class="sales-add-option" ng-click="holdCloseEditSales('Close');">
                    <i class="fa fa-file"></i><br/>
                    Close Order
                </div>
            </div>
        </div>
    </div>
    <div class="col m7 l7 s12 z-depth-1">
        <div class="sales-add-products-categories" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
            @foreach($categories as $category)
            <div id="sales-add-products-category-{{$category->id}}" class="sales-add-products-category" ng-click="getSalesAddProducts('{{$category->id}}')">{{$category->name}}</div>
            @endforeach
        </div>
        <div class="sales-add-products-content" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
            <div style="padding:5px;font-size:1.2em;">[[salesProductsCategory]]</div>
            <div class="row" ng-init="getSalesAddProducts('8')">
                <div style="padding:10px;text-align:center;" ng-hide="salesProductsLoader">
                    <img src="{{URL('img/loader.gif')}}" width="45px" height="45px"/>
                </div>
                <div style="padding:10px;" ng-hide="salesProductsEmpty">
                    No Result(s).
                </div>
                <div class="sales-add-product center-align col m3 l3 s6" ng-repeat="salesProduct in salesProducts">
                    <div class="sales-add-product-img"
                         style="
                         background:url('/POS/[[salesProduct.image]]') center no-repeat;
                         background-size:cover;
                         "></div>
                    <div class="sales-add-product-name [[salesProduct.id]]-name">[[salesProduct.name]]</div>
                    <div class="sales-add-product-price [[salesProduct.id]]-price">[[salesProduct.retail_price | number]]</div>
                    <div class="sales-add-product-qty [[salesProduct.id]]-qty" ng-bind-html="salesProduct.stock"></div>
                    <div class="sales-add-product-add" ng-click="addSalesProduct(salesProduct.id);">
                        <i class="fa fa-plus"></i> Add
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
