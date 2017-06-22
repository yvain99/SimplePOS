@extends('template/home')
@section('title', 'Point Of Sales - Categories')
@section('content')
<div class="row">
    <div class="product-categories-content col m6 l6 s12">
        <div class="product-categories-form">
            {!! Form::open(['id' => 'add-product-category-form', 'url' => 'addProductCategory']) !!}
            <div class="input-field" style="width:70%;display:inline-block;">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_category_name" name="product-category-name" type="text" class="validate" ng-model="productCategoryName">
                <label for="icon_category_name">Category Name</label>
            </div>
            <button id="product-categories-add-btn" type="submit"><i class="fa fa-plus"></i> Add</button>

            @if($errors->has('product-category-name'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-category-name') . ')</div>'; ?>
            @endif

            @if(session('successCategory'))
            <?php echo '<div style="color:#64dd17;padding-bottom:20px;">(' . session('successCategory') . ')</div>'; ?>
            @endif
            {!! Form::close() !!}
        </div>
        <div class="product-categories-table">
            <table class="centered bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>
                            <div class="product-category-remove" ng-click="rpc('{{$category->id}}')">
                                <i class="fa fa-times"></i> Remove
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="product-units-content col m6 l6 s12">
        <div class="product-units-form">
            {!! Form::open(['id' => 'add-unit-category-form', 'url' => 'addProductUnit']) !!}
            <div class="input-field" style="width:70%;display:inline-block;">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_unit_name" name="product-unit-name" type="text" class="validate" ng-model="productUnitName">
                <label for="icon_unit_name">Unit Name</label>
            </div>
            <button id="product-unit-add-btn" type="submit"><i class="fa fa-plus"></i> Add</button>
            @if($errors->has('product-unit-name'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('product-unit-name') . ')</div>'; ?>
            @endif

            @if(session('successUnit'))
            <?php echo '<div style="color:#64dd17;padding-bottom:20px;">(' . session('successUnit') . ')</div>'; ?>
            @endif
            {!! Form::close() !!}
        </div>
        <div class="product-units-table">
            <table class="centered bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <td>{{$unit->id}}</td>
                        <td>{{$unit->name}}</td>
                        <td>
                            <div class="product-unit-remove" ng-click="rpm('{{$unit->id}}')">
                                <i class="fa fa-times"></i> Remove
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
