@extends('template/home')
@section('title', 'Point Of Sales - Suppliers')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="supplier-header">
        {!! Form::open(['id' => 'supplier-search-form', 'url' => 'suppliers', 'method' => 'GET']) !!}
        <div class="input-field supplier-search-input">
            <input id="supplier-sv" type="text" name="sv" placeholder="Type Keywords.." max-length="100" value="{{@$sv}}"/>
        </div>
        <div class="input-field supplier-search-input">
            {{ 
                Form::select('sc', [
                    'name' => 'Name',
                    'email' => 'Email'
                ], @$sc, ['id' => 'supplier-sc']) 
            }}
        </div>
        <button class="supplier-search-input"><i class="fa fa-search"></i> Search</button>
        {!! Form::close() !!}
    </div>
    <div class="supplier-content" 
        ng-nicescroll 
        nice-option="{cursorcolor:'#c0c0c0'}"
        when-scrolled="getMoreSuppliers()">
        <table class="centered bordered striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                <tr class="supplier">
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->address}}</td>
                    <td>{{$supplier->phone}}</td>
                    <td>{{$supplier->email}}</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="supplier-opt-btn col m6 l6 s6" title="edit" ng-click="editSupplier('{{$supplier->id}}');">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="supplier-opt-btn col m6 l6 s6" title="remove" ng-click="removeSupplier('{{$supplier->id}}');">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr class="supplier" ng-repeat="supplier in suppliers">
                    <td>[[supplier.name]]</td>
                    <td>[[supplier.address]]</td>
                    <td>[[supplier.phone]]</td>
                    <td>[[supplier.email]]</td>
                    <td>
                        <div class="row" style="margin:0;">
                            <div class="supplier-opt-btn col m6 l6 s6" 
                                 title="edit" 
                                 ng-click="editSupplier(supplier.id);">
                                <i class="fa fa-edit fa-lg"></i>
                            </div>
                            <div class="supplier-opt-btn col m6 l6 s6" 
                                 title="remove" 
                                 ng-click="removeSupplier(supplier.id);">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr ng-show="suppliersLoader">
                    <td colspan="5"><img src="{{asset('img/loader.gif')}}" width="25px" height="25px"/></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
