@extends('template/home')
@section('title', 'Point Of Sales - Edit Customer')
@section('content')

<h4 style="margin:0;padding:10px;">Edit Customer</h4>
<div class="customers-add-form">
    {!! Form::open(['id' => 'edit-customer-form', 'url' => 'editCustomer']) !!}
    <div class="row">
        <input name="customer-username" type="hidden" class="validate" value="{{$customer[0]->username}}">
        <input name="customer-password" type="hidden" value="{{$customer[0]->password}}">
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_customer_name" name="customer-name" type="text" class="validate" value="{{$customer[0]->name}}">
                <label for="icon_customer_name">Customer Name</label>
                @if($errors->has('customer-name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('customer-name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-envelope prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_customer_email" name="customer-email" type="email" class="validate" value="{{$customer[0]->email}}">
                <label for="icon_customer_email">Customer Email</label>
                @if($errors->has('customer-email'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('customer-email') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-phone-square prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_customer_phone" name="customer-phone" type="tel" class="validate" value="{{$customer[0]->phone}}">
                <label for="icon_customer_phone">Customer Phone</label>
                @if($errors->has('customer-phone'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('customer-phone') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="clearfix"></div>

        @if(session('successCustomer'))
        <?php echo '<div style="color:#64dd17;margin:15px 0 0 20px;">(' . session('successCustomer') . ')</div>'; ?>
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
