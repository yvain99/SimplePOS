@extends('template/home')
@section('title', 'Point Of Sales - Products')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="product-header">
        {!! Form::open(['id' => 'product-search-form', 'url' => 'products', 'method' => 'GET']) !!}
        <div class="input-field product-search-input">
            <input id="product-sv" type="text" name="sv" placeholder="Type Keywords.." max-length="100" value="{{@$sv}}"/>
        </div>
        <div class="input-field product-search-input">
            {{ 
                Form::select('sc', [
                    'product.sku' => 'SKU',
                    'product.name' => 'Name',
                    'product_category.name' => 'Category'
                ], @$sc, ['id' => 'product-sc']) 
            }}
        </div>
        <button class="product-search-input"><i class="fa fa-search"></i> Search</button>
        {!! Form::close() !!}
    </div>
    <div class="product-content" 
         ng-nicescroll 
         nice-option="{cursorcolor:'#c0c0c0'}"
         when-scrolled="getMoreProducts()">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th></th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Purchase Price</th>
                    <th>Retail Price</th>
                    <th>Stock</th>
                    <th>Has Ingredients?</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($products) > 0)
                @foreach($products as $product)
                <?php
                if (is_null($product->image))
                    $product->image = 'img/product/product_default.jpg';
                else
                    $product->image = 'img/product/' . $product->image
                    ?>
                <tr class="product">
                    <td>
                        <div style="
                             background:url({{asset($product->image)}}) center no-repeat;
                             background-size:cover;
                             width:50px;
                             height:50px;
                             border:1px solid #e1e1e1;
                             ">
                        </div>
                    </td>
                    <td>{{$product->sku}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{number_format($product->purchase_price)}}</td>
                    <td>{{number_format($product->retail_price)}}</td>
                    <td>{{number_format($product->stock)}}</td>
                    <td>{{$product->ingredients}}</td>
                    <td>{{$product->category_name}}</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="product-opt-btn col m6 l6 s6" title="edit" ng-click="editProduct('{{$product->id}}');">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="product-opt-btn col m6 l6 s6" title="remove" ng-click="removeProduct('{{$product->id}}');">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr class="product" ng-repeat="product in products">
                    <td>
                        <div style="
                             background:url('[[product.image]]') center no-repeat;
                             background-size:cover;
                             width:50px;
                             height:50px;
                             border:1px solid #e1e1e1;
                             ">
                        </div>
                    </td>
                    <td>[[product.sku]]</td>
                    <td>[[product.name]]</td>
                    <td>[[product.purchase_price | number]]</td>
                    <td>[[product.retail_price | number]]</td>
                    <td>[[product.stock | number]]</td>
                    <td>[[product.ingredients]]</td>
                    <td>[[product.category_name]]</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="product-opt-btn col m6 l6 s6" 
                                 title="edit" 
                                 ng-click="editProduct(product.id);">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="product-opt-btn col m6 l6 s6" 
                                 title="remove" 
                                 ng-click="removeProduct(product.id);">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr ng-show="productsLoader">
                    <td colspan="5"><img src="{{asset('img/loader.gif')}}" width="25px" height="25px"/></td>
                </tr>

                @else
                <tr><td colspan="10">No Product(s) Yet.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
