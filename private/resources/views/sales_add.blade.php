@extends('template/home')
@section('title', 'Point Of Sales - New Sales Order')
@section('content')

<div class="sales-add-content row">
    <div class="col m5 l5 s12 z-depth-1">
        {!! Form::open(['id' => 'add-sales-form', 'url' => 'addNewSales']) !!}
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
                <div style="font-size:0.75em;">
                    <table id="sales-add-table" width="100%">
                        <tbody>
                            <tr>
                                <td>{{date('d/m/Y, h:i:s A', time())}}</td>
                                <td class="right-align">
                                    <input type="hidden" name="sales-id" value="[[salesId]]"/>
                                    #<span id="sales-add-id">S{{$salesId}}</span>
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
                                    //[[salesDescription]]
                                </td>
                                <td class="right-align" colspan="2">
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
        </span>
        {!! Form::close() !!}

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
                <div class="sales-add-option" ng-click="holdCloseSales('Hold')">
                    <i class="fa fa-file"></i><br/>
                    Hold Order
                </div>
                <div class="sales-add-option" ng-click="holdCloseSales('Close')">
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
                    <img src="img/loader.gif" width="45px" height="45px"/>
                </div>
                <div style="padding:10px;" ng-hide="salesProductsEmpty">
                    No Result(s).
                </div>
                <div class="sales-add-product center-align col m3 l3 s6" ng-repeat="salesProduct in salesProducts">
                    <div class="sales-add-product-img"
                         style="
                         background:url('[[salesProduct.image]]') center no-repeat;
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
