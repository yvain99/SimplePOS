@extends('template/home')
@section('title', 'Point Of Sales - Edit Product Ingredients')
@section('content')
<div class="edit-product-ingredients-content">
    <div class="row">
        <div class="col m4 l4 s12">
            <div class="edit-product-ingredients-search-content">
                <div class="input-field edit-product-ingredients-search-input">
                    <input type="text" placeholder="Search Ingredient.." max-length="100" ng-model="episv" ng-keyup="editProductIngredientsFilter(episv);"/>
                </div>
                <i class="fa fa-search fa-lg"></i>
            </div>
            <div class="edit-product-ingredients-all">
                <table class="centered bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Unit Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingredients as $ingredient)
                        <tr class="edit-product-ingredient">
                            <td width="40%" class="edit-product-ingredient-name {{$ingredient->id}}-name">{{$ingredient->name}}</td>
                            <td width="40%" class="{{$ingredient->id}}-unit">{{$ingredient->unit_name}}</td>
                            <td width="20%">
                                <div class="edit-product-ingredients-add-btn" ng-click="addProductIngredient('{{$ingredient->id}}');">
                                    <i class="fa fa-plus"></i> Add
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col m8 l8 s12" style="padding:0 10px 0 10px;">
            <div style="height:66px;line-height:60px;font-size:1.2em;font-weight:bold;">Ingredients Assigned</div>
            <div class="edit-product-ingredients-assigned">
                {!! Form::open(['id' => 'edit-product-ingredients-form', 'url' => 'editProductIngredients']) !!}
                <input type="hidden" 
                       name="product-id" 
                       value="{{$id}}"/>
                <table class="centered bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Unit Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productIngredients as $productIngredient)
                        <tr id="{{$productIngredient->ingredient_id}}-ingredient">
                            <td width="25%">
                                <input 
                                    type="hidden" 
                                    name="ingredient-id[]" 
                                    value="{{$productIngredient->ingredient_id}}"/>
                                {{$productIngredient->ingredient_name}}
                            </td>
                            <td width="25%">
                                <input 
                                    id="{{$productIngredient->ingredient_id}}-qty"
                                    type="number" 
                                    name="ingredient-qty[]" 
                                    min="0.01"
                                    max="999999"
                                    step="any"
                                    value="{{$productIngredient->qty}}"
                                    style="width:50%;text-align:center;"/>
                            </td>
                            <td width="25%">
                                {{$productIngredient->unit_name}}
                            </td>
                            <td width="25%">
                                <div class="edit-product-ingredients-remove-btn" 
                                     ng-click="removeProductIngredient('{{$productIngredient->ingredient_id}}');">
                                    <i class="fa fa-times"></i> Remove
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(session('successProductIngredients'))
                <?php echo '<div style="color:#64dd17;margin:15px 0 0 20px;">(' . session('successProductIngredients') . ')</div>'; ?>
                @endif

                <div class="right">
                    <div class="center-align" style="margin-top:20px;">
                        <i class="login-btn btn waves-effect waves-light" style="display:block;width:10em;">
                            <input class="waves-button-input" type="submit" value="Save" style="width:100%;height:100%;"/>
                        </i>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    @stop
