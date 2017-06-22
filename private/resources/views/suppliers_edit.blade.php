@extends('template/home')
@section('title', 'Point Of Sales - Edit Supplier')
@section('content')

<h4 style="margin:0;padding:10px;">Edit Supplier</h4>
<div class="suppliers-edit-form">
    {!! Form::open(['id' => 'edit-supplier-form', 'url' => 'editSupplier']) !!}
    <div class="row">
        <input type="hidden" name="supplier-id" value="{{$supplier->id}}"/>
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_supplier_name" name="supplier-name" type="text" class="validate" value="{{$supplier->name}}">
                <label for="icon_supplier_name">Supplier Name</label>
                @if($errors->has('supplier-name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('supplier-name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-home prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_supplier_address" name="supplier-address" type="text" class="validate" value="{{$supplier->address}}">
                <label for="icon_supplier_address">Supplier Address</label>
                @if($errors->has('supplier-address'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('supplier-address') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-phone-square prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_supplier_phone" name="supplier-phone" type="tel" class="validate" value="{{$supplier->phone}}">
                <label for="icon_supplier_phone">Supplier Phone</label>
                @if($errors->has('supplier-phone'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('supplier-phone') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-envelope prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_supplier_email" name="supplier-email" type="email" class="validate" value="{{$supplier->email}}">
                <label for="icon_supplier_email">Supplier Email</label>
                @if($errors->has('supplier-email'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('supplier-email') . ')</div>'; ?>
                @endif
            </div>
        </div>

        @if(session('successSupplier'))
        <?php echo '<div style="color:#64dd17;margin-left:20px;">(' . session('successSupplier') . ')</div>'; ?>
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
