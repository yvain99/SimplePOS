@extends('template/home')
@section('title', 'Point Of Sales - Pending Purchases')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="purchase-content" 
         ng-nicescroll 
         nice-option="{cursorcolor:'#c0c0c0'}"
         style="padding-top:0;">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Admin</th>
                    <th>Total Qty</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($purchaseArr) > 0)
                @foreach($purchaseArr as $purchase)
                <tr class="purchase">
                    <td>{{$purchase->id}}</td>
                    <td>{{$purchase->admin}}</td>
                    <td>{{number_format($purchase->total_qty)}}</td>
                    <td>{{number_format($purchase->total)}}</td>
                    <td>
                        <a href="purchase_pending/{{$purchase->id}}">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr><td colspan="10">No Purchase(s) Yet.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
