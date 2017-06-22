@extends('template/home')
@section('title', 'Point Of Sales - Customers')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="customer-header">
        {!! Form::open(['id' => 'customer-search-form', 'url' => 'customers', 'method' => 'GET']) !!}
        <div class="input-field customer-search-input">
            <input id="customer-sv" type="text" name="sv" placeholder="Type Keywords.." max-length="100" value="{{@$sv}}"/>
        </div>
        <div class="input-field customer-search-input">
            {{ 
                Form::select('sc', [
                    'username' => 'Username',
                    'name' => 'Name',
                    'email' => 'Email'
                ], @$sc, ['id' => 'customer-sc']) 
            }}
        </div>
        <button class="customer-search-input"><i class="fa fa-search"></i> Search</button>
        {!! Form::close() !!}
    </div>
    <div class="customer-content" 
         ng-nicescroll 
         nice-option="{cursorcolor:'#c0c0c0'}"
         when-scrolled="getMoreCustomers()">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($customers) > 0)
                @foreach($customers as $customer)
                <tr class="customer">
                    <td>{{$customer->username}}</td>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="customer-opt-btn col m6 l6 s6" title="edit" ng-click="editCustomer('{{$customer->username}}');">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="customer-opt-btn col m6 l6 s6" title="remove" ng-click="removeCustomer('{{$customer->username}}');">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr class="customer" ng-repeat="customer in customers">
                    <td>[[customer.username]]</td>
                    <td>[[customer.name]]</td>
                    <td>[[customer.email]]</td>
                    <td>[[customer.phone]]</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="customer-opt-btn col m6 l6 s6" 
                                 title="edit" 
                                 ng-click="editCustomer(customer.username);">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="customer-opt-btn col m6 l6 s6" 
                                 title="remove" 
                                 ng-click="removeCustomer(customer.username);">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr ng-show="customersLoader">
                    <td colspan="5"><img src="{{asset('img/loader.gif')}}" width="25px" height="25px"/></td>
                </tr>

                @else
                <tr><td colspan="10">No Customer(s) Yet.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
