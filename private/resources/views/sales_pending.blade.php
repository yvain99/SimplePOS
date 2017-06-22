@extends('template/home')
@section('title', 'Point Of Sales - Pending Sales')
@section('content')

<h5 style="margin:0;">Pending Orders</h5>
<div class="sales-pending-content row" style="margin-top:10px;">
    @foreach($salesArr as $sales)
    <div class="col m2 l2 s12 center-align" style="padding:5px;">
        <a href="{{URL('sales_pending/'. $sales->id)}}">
            <div class="sales-pending">
                <div class="sales-pending-id">#{{$sales->id}}</div>
                <div class="sales-pending-desc">{{$sales->description}}</div>
                <div class="sales-pending-qty"><b>Qty</b> {{$sales->total_qty}}</div>
                <div class="sales-pending-price"><b>Total</b> {{number_format($sales->total)}}</div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@stop
