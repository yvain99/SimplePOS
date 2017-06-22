@extends('template/home')
@section('title', 'Point Of Sales - Edit Product')
@section('content')

<h4 style="margin:0;padding:10px;">Edit Product</h4>
<div class="products-edit-form">
    {!! Form::open(['id' => 'edit-product-form', 'url' => 'editProduct', 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="product-id" value="{{$product->id}}"/>
    <input type="hidden" name="product-image-old" value="{{$product->image}}"/>
    <div class="row">
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_sku" name="product-sku" type="text" class="validate" value="{{$product->sku}}">
                <label for="icon_product_sku">Product SKU</label>
                @if($errors->has('product-sku'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-sku') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_name" name="product-name" type="text" class="validate" value="{{$product->name}}">
                <label for="icon_product_name">Product Name</label>
                @if($errors->has('product-name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-money prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_pprice" name="product-pprice" type="number" class="validate" value="{{$product->purchase_price}}">
                <label for="icon_product_pprice">Product Purchase Price</label>
                @if($errors->has('product-pprice'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-pprice') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-money prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_rprice" name="product-rprice" type="number" class="validate" value="{{$product->retail_price}}">
                <label for="icon_product_rprice">Product Retail Price</label>
                @if($errors->has('product-rprice'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-rprice') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-calculator prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_rprice" name="product-stock" type="number" class="validate" value="{{$product->stock}}">
                <label for="icon_product_rprice">Product Stock</label>
            </div>
        </div>

        
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-exclamation-triangle prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_product_alert_qty" name="product-alert-qty" type="number" min="1" max="999999" class="validate" value="{{$product->alert_qty}}">
                <label for="icon_product_alert_qty">Product Alert Qty</label>
                @if($errors->has('product-alert-qty'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-alert-qty') . ')</div>'; ?>
                @endif
            </div>
        </div>
        
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag fa-lg prefix" style="font-size:1.5em;left:0;top:15px;"></i>
                <?php
                $categoriesArr = array();
                foreach ($categories as $category) {
                    $categoriesArr[$category->id] = $category->name;
                }
                ?>
                {{
                    Form::select('product-category', $categoriesArr, $product->category) 
                }}
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

        <div class="col m6 l6 s12">
            <?php
            if ($product->ingredients == "Yes") {
                $editIngredientsBtn = '<a href="' . $product->id . '/ingredients">' .
                        '<div class="edit-ingredients-btn">' .
                        '<i class="fa fa-edit"></i> Edit Ingredients' .
                        '</div>' .
                        '</a>';
            } else
                $editIngredientsBtn = '';

            echo $editIngredientsBtn;
            ?>
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
