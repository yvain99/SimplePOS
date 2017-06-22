@extends('template/home')
@section('title', 'Point Of Sales - Add New Product')
@section('content')

<h4 style="margin:0;padding:10px;">Add New Product</h4>
<div class="products-add-form">
    {!! Form::open(['id' => 'add-product-form', 'url' => 'addNewProduct', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_sku" name="product-sku" type="text" class="validate" ng-model="productSKU">
                <label for="icon_product_sku">Product SKU</label>
                @if($errors->has('product-sku'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-sku') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_name" name="product-name" type="text" class="validate" ng-model="productName">
                <label for="icon_product_name">Product Name</label>
                @if($errors->has('product-name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-money prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_pprice" name="product-pprice" type="number" class="validate" value="0">
                <label for="icon_product_pprice">Product Purchase Price</label>
                @if($errors->has('product-pprice'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-pprice') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-money prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_rprice" name="product-rprice" type="number" class="validate" value="0">
                <label for="icon_product_rprice">Product Retail Price</label>
                @if($errors->has('product-rprice'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-rprice') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-calculator prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_rprice" name="product-stock" type="number" class="validate" value="0">
                <label for="icon_product_rprice">Product Stock</label>
            </div>
        </div>
        
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-exclamation-triangle prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_alert_qty" name="product-alert-qty" type="number" min="1" max="999999" class="validate" value="0">
                <label for="icon_product_alert_qty">Product Alert Qty</label>
                @if($errors->has('product-alert-qty'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-alert-qty') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag fa-lg prefix" style="font-size:1.5em;left:0;top:15px;"></i>
                <select name="product-category">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                <label for="icon_product_category">Product Category</label>
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="file-field input-field" style="padding-left:10px;">
                <div class="btn">
                    <span><i class="fa fa-image"></i> Product Image</span>
                    <input type="file" name="product-image" accept="image/*">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
                @if($errors->has('product-image'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-image') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <p style="padding-left:15px;">
                <input type="checkbox" class="filled-in" id="product-ingredients" name="product-ingredients" value="Yes"/>
                <label for="product-ingredients">Has Ingredients?</label>
            </p>
        </div>

        <div class="clearfix"></div>

        @if(session('successProduct'))
        <?php echo '<div style="color:#64dd17;margin:15px 0 0 20px;">(' . session('successProduct') . ')</div>'; ?>
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
