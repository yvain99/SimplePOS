@extends('template/home')
@section('title', 'Point Of Sales - New Purchase Order')
@section('content')

<div class="purchase-add-content row">
    <div class="col m7 l7 s12 z-depth-1">
        {!! Form::open(['id' => 'add-purchase-form', 'url' => 'addNewPurchase']) !!}
        <div class="purchase-add-header center-align">
            <input id="purchase-add-id" type="hidden" name="purchase-add-id" value="P{{$purchaseId}}"/>
            #<span>P{{$purchaseId}}</span>
        </div>
        <div class="purchase-add-products" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
            <table id="purchase-add-products-table" class="centered" width="100%">
                <tbody>
                    <tr>
                        <td width="15%">Qty</td>
                        <td>Name</td>
                        <td>Each</td>
                        <td>Total</td>
                        <td>Supplier</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="purchase-add-footer">
            <div class="right-align">Total: <span id="purchase-total">[[purchaseTotal]]</span></div>
            <div class="purchase-add-options right-align">
                <div class="purchase-add-option" ng-click="holdClosePurchase('Hold')">
                    <i class="fa fa-file"></i> Hold Order
                </div>
                <div class="purchase-add-option" ng-click="holdClosePurchase('Close')">
                    <i class="fa fa-file"></i> Close Order
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col m5 l5 s12 z-depth-1">
        <div class="purchase-add-suppliers">
            Select Supplier: 
            <div class="input-field purchase-add-suppliers-input">
                <select id="purchase-add-suppliers-select">
                    <option value="">- Select Supplier-</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="purchase-add-search-form">
            <div class="input-field purchase-add-search-input">
                <input id="purchase-add-value" type="text" placeholder=" Products/Ingredients Name.." ng-keyup="purchaseSearch()"/>
            </div>
            <div class="input-field purchase-add-search-input">
                <select id="purchase-add-select">
                    <option value="0">Ingredients</option>
                    <option value="1">Products</option>
                </select>
            </div>
        </div>
        <div class="purchase-add-search-result-content row" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}" ng-init="getPurchaseSearchResults('', '0')">
            <div ng-show="purchaseAddEmpty">No Result(s).</div>
            <div class="center-align" ng-show="purchaseAddLoader" style="padding:10px;">
                <img src="{{asset('img/loader.gif')}}" width="30px" height="30px"/>
            </div>

            <div class="purchase-add-product col m4 l4 s6" ng-repeat="purchaseAddProduct in purchaseAddProducts">
                <div class="purchase-add-product-img"
                     style="
                     background:url('[[purchaseAddProduct.image]]') center no-repeat;
                     background-size:cover;
                     "></div>
                <div class="purchase-add-product-name [[purchaseAddProduct.id]]-name">
                    [[purchaseAddProduct.name]]
                </div>
                <div class="purchase-add-product-price">
                    @<span class="[[purchaseAddProduct.id]]-price">
                        [[purchaseAddProduct.purchase_price | number]]
                    </span>
                </div>
                <div class="purchase-add-product-qty">
                    Stock: [[purchaseAddProduct.stock]]
                </div>

                <div class="row" style="margin:0;padding:10px;">
                    <div class="purchase-add-product-add col m6 l6 s6">
                        <input class="[[purchaseAddProduct.id]]-qty" type="number" min="0" max="999999" placeholder="[[purchaseAddProduct.unit_type]]" style="height:20px;margin:0;"/>
                    </div>
                    <div class="purchase-add-product-add col m6 l6 s6" ng-click="addPurchaseProduct(purchaseAddProduct.id);">
                        <i class="fa fa-plus"></i> Add
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop
