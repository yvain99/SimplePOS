@extends('template/home')
@section('title', 'Point Of Sales - Add New Ingredient')
@section('content')

<h4 style="margin:0;padding:10px;">Add New Ingredient</h4>
<div class="ingredients-add-form">
    {!! Form::open(['id' => 'add-ingredient-form', 'url' => 'addNewIngredient']) !!}
    <div class="row">
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_ingredient_name" name="ingredient-name" type="text" class="validate" ng-model="ingredientName">
                <label for="icon_ingredient_name">Ingredient Name</label>
                @if($errors->has('ingredient-name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('ingredient-name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-calculator prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_ingredient_qty" name="ingredient-qty" type="number" min="1" max="999999" class="validate" ng-model="ingredientQty">
                <label for="icon_ingredient_qty">Ingredient Qty</label>
                @if($errors->has('ingredient-qty'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('ingredient-qty') . ')</div>'; ?>
                @endif
            </div>
        </div>
        
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-exclamation-triangle prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_ingredient_alert_qty" name="ingredient-alert-qty" type="number" min="1" max="999999" class="validate" value="0">
                <label for="icon_ingredient_alert_qty">Ingredient Alert Qty</label>
                @if($errors->has('ingredient-alert-qty'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('ingredient-alert-qty') . ')</div>'; ?>
                @endif
            </div>
        </div>
        
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-money prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_ingredient_pprice" name="ingredient-pprice" type="number" class="validate" ng-model="ingredientPprice">
                <label for="icon_ingredient_pprice">Ingredient Purchase Price</label>
                @if($errors->has('ingredient-pprice'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('ingredient-pprice') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-balance-scale fa-lg prefix" style="font-size:1.5em;left:0;"></i>
                <select name="ingredient-unit">
                    @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach
                </select>
                <label for="icon_ingredient_unit">Ingredient Unit</label>
            </div>
        </div>
        
        <div class="clearfix"></div>

        @if(session('successIngredient'))
        <?php echo '<div style="color:#64dd17;margin-left:20px;">(' . session('successIngredient') . ')</div>'; ?>
        @endif

        <div class="right">
            <i class="btn waves-effect waves-light" style="display:block;width:10em;">
                <input class="waves-button-input" type="submit" value="Submit" style="width:100%;height:100%;"/>
            </i>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop
