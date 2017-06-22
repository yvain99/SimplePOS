@extends('template/home')
@section('title', 'Point Of Sales - Ingredients')
@section('content')

<div style="position:relative;height:100%;">
    <div class="ingredients-header">
        <div class="left">
            <b style="font-size:1.5em;">Ingredients</b>
        </div>
        <div class="right">
            <a href="{{URL('ingredients_add')}}">
                <div class="add-ingredient-btn"><i class="fa fa-plus-circle"></i> Add New Ingredient</div>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="ingredients-content">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Purchase Price</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $ingredient)
                <tr class="ingredient">
                    <td>{{$ingredient->id}}</td>
                    <td>{{$ingredient->name}}</td>
                    <td>{{$ingredient->qty}}</td>
                    <td>{{number_format($ingredient->purchase_price)}}</td>
                    <td>{{$ingredient->unit_name}}</td>
                    <td width="20%">
                        <div class="row" style="margin:0;">
                            <div class="ingredient-opt-btn col m6 l6 s6" 
                                 title="edit" 
                                 ng-click="editIngredient('{{$ingredient->id}}');">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="ingredient-opt-btn col m6 l6 s6" 
                                 title="remove" 
                                 ng-click="removeIngredient('{{$ingredient->id}}');">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
