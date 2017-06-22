@extends('template/home')
@section('title', 'Point Of Sales - Complete Sales')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="sales-header">
        {!! Form::open(['id' => 'sales-search-form', 'url' => 'sales_complete', 'method' => 'GET']) !!}
        <div class="input-field sales-search-input">
            <input id="sales-sv" type="text" name="sv" placeholder="Type Keywords.." max-length="100" value="{{@$sv}}"/>
        </div>
        <div class="input-field sales-search-input">
            {{ 
                Form::select('sc', [
                    'id' => 'ID',
                    'customer' => 'Customer',
                    'payment_method' => 'Payment Method'
                ], @$sc, ['id' => 'sales-sc']) 
            }}
        </div>
        <button class="sales-search-input"><i class="fa fa-search"></i> Search</button>
        {!! Form::close() !!}
    </div>
    <div class="sales-content" 
         ng-nicescroll 
         nice-option="{cursorcolor:'#c0c0c0'}"
         when-scrolled="getMoreCompleteSales()">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Admin</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($sales) > 0)
                @foreach($sales as $sales)
                <tr class="sales">
                    <td>{{$sales->id}}</td>
                    <td>{{$sales->description}}</td>
                    <td>{{$sales->admin}}</td>
                    <td>{{$sales->customer}}</td>
                    <td>{{number_format($sales->total_qty)}}</td>
                    <td>{{number_format($sales->total)}}</td>
                    <td>{{$sales->payment_method . ' ' . $sales->payment_method_number}}</td>
                    <td>
                        <a href="sales_complete/{{$sales->id}}">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                <tr class="sales" ng-repeat="sales in sales">
                    <td>[[sales.id]]</td>
                    <td>[[sales.description]]</td>
                    <td>[[sales.admin]]</td>
                    <td>[[sales.customer]]</td>
                    <td>[[sales.total_qty]]</td>
                    <td>[[sales.total]]</td>
                    <td>[[sales.payment_method + ' ' + sales.payment_method_number]]</td>
                    <td>
                        <a href="sales_complete/[[sales.id]]">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <tr ng-show="salesLoader">
                    <td colspan="5"><img src="{{asset('img/loader.gif')}}" width="25px" height="25px"/></td>
                </tr>

                @else
                <tr><td colspan="10">No Sales Yet.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
