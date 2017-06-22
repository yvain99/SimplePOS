@extends('template/home')
@section('title', 'Point Of Sales - Complete Purchase')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="purchase-header">
        {!! Form::open(['id' => 'purchase-search-form', 'url' => 'purchase_complete', 'method' => 'GET']) !!}
        <div class="input-field purchase-search-input">
            <input id="purchase-sv" type="text" name="sv" placeholder="Type Keywords.." max-length="100" value="{{@$sv}}"/>
        </div>
        <div class="input-field purchase-search-input">
            {{ 
                Form::select('sc', [
                    'id' => 'ID'
                ], @$sc, ['id' => 'purchase-sc']) 
            }}
        </div>
        <button class="purchase-search-input"><i class="fa fa-search"></i> Search</button>
        {!! Form::close() !!}
    </div>
    <div class="purchase-content" 
         ng-nicescroll 
         nice-option="{cursorcolor:'#c0c0c0'}"
         when-scrolled="getMoreCompletePurchases()">
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
                @if (count($purchase) > 0)
                @foreach($purchase as $purchase)
                <tr class="purchase">
                    <td>{{$purchase->id}}</td>
                    <td>{{$purchase->admin}}</td>
                    <td>{{number_format($purchase->total_qty)}}</td>
                    <td>{{number_format($purchase->total)}}</td>
                    <td>
                        <a href="purchase_complete/{{$purchase->id}}">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                <tr class="purchase" ng-repeat="purchase in purchases">
                    <td>[[purchase.id]]</td>
                    <td>[[purchase.admin]]</td>
                    <td>[[purchase.total_qty | number]]</td>
                    <td>[[purchase.total | number]]</td>
                    <td>
                        <a href="purchase_complete/[[purchase.id]]">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <tr ng-show="purchaseLoader">
                    <td colspan="5"><img src="{{asset('img/loader.gif')}}" width="25px" height="25px"/></td>
                </tr>

                @else
                <tr><td colspan="10">No Purchase Yet.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
