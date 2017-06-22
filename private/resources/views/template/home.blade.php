<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="Point of Sales"/>
        <meta name="description" content="description"/>
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>@yield('title')</title>
        <link rel="SHORTCUT ICON" href="{{asset('img/title.ico')}}" />

        <title>Point Of Sales</title>
        {!! Html::style('css/font/css/font-awesome.min.css') !!}
        {!! Html::style('css/materialize.css') !!}
        {!! Html::style('css/swal.css') !!}
        {!! Html::style('css/index.css') !!}
    </head>
    <body ng-app="myApp">
        <div class="home-container" ng-controller="homeController">
            <ul id="slide-out" class="side-nav" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
                <li>
                    <a href="{{URL('dashboard')}}"><i class="fa fa-dashboard fa-lg"></i> Dashboard</a>
                </li>
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Sales</b>
                </li>
                <li>
                    <a href="{{URL('sales_add')}}"><i class="fa fa-list-alt"></i> Make Order</a>
                </li>
                <li>
                    <a href="{{URL('sales_pending')}}"><i class="fa fa-question-circle"></i> Pending Order</a>
                </li>
                <li>
                    <a href="{{URL('sales_complete')}}"><i class="fa fa-check-square"></i> Complete Order</a>
                </li>
                <li>
                    <a href="{{URL('sales_report')}}"><i class="fa fa-file-o"></i> Report</a>
                </li>
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Purchase</b>
                </li>
                <li>
                    <a href="{{URL('purchase_add')}}"><i class="fa fa-list-alt"></i> Make Order</a>
                </li>
                <li>
                    <a href="{{URL('purchase_pending')}}"><i class="fa fa-question-circle"></i> Pending Order</a>
                </li>
                <li>
                    <a href="{{URL('purchase_complete')}}"><i class="fa fa-check-square"></i> Complete Order</a>
                </li>
                <li>
                    <a href="{{URL('purchase_report')}}"><i class="fa fa-file-o"></i> Report</a>
                </li>
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Products</b>
                </li>
                
                @if(session('role') == 'admin')
                <li>
                    <a href="{{URL('products_add')}}"><i class="fa fa-plus-circle"></i> Add New Product</a>
                </li>
                <li>
                    <a href="{{URL('products')}}"><i class="fa fa-list"></i> List of Products</a>
                </li>
                @endif
                
                <li>
                    <a href="{{URL('products_report')}}"><i class="fa fa-file-o"></i> Report</a>
                </li>
                
                @if(session('role') == 'admin')
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Suppliers</b>
                </li>
                <li>
                    <a href="{{URL('suppliers_add')}}"><i class="fa fa-plus-circle"></i> Add New Supplier</a>
                </li>
                <li>
                    <a href="{{URL('suppliers')}}"><i class="fa fa-list"></i> List of Suppliers</a>
                </li>
                @endif
                
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Customers</b>
                </li>
                <li>
                    <a href="{{URL('customers_add')}}"><i class="fa fa-plus-circle"></i> Add New Customer</a>
                </li>
                <li>
                    <a href="{{URL('customers')}}"><i class="fa fa-list"></i> List of Customers</a>
                </li>
                
                @if(session('role') == 'admin')
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Ingredients & Categories</b>
                </li>
                <li>
                    <a href="{{URL('ingredients')}}"><i class="fa fa-list"></i> List of Ingredients</a>
                </li>
                <li>
                    <a href="{{URL('categories')}}"><i class="fa fa-list"></i> List of Categories</a>
                </li>
                @endif
                
                <li style="padding-left:20px;background:#f0f0f0;">
                    <b>Others</b>
                </li>
                
                @if(session('role') == 'admin')
                <li>
                    <a href="{{URL('accounts')}}"><i class="fa fa-users"></i> Accounts</a>
                </li>
                @endif
                
                <li>
                    <a href="{{URL('settings')}}"><i class="fa fa-gear"></i> Settings</a>
                </li>
            </ul>

            <div class="loader" ng-show="loader">
                <img src="{{asset('img/loader.gif')}}" width="64px" height="64px"/>
            </div>
            <div class="header" style="background:#f0f0f0;">
                <div class="left" style="width:50%;">
                    <b><span class="company-name"></span> Point Of Sales</b>
                    <div style="font-size:0.9em;margin-top:5px;">[[ time ]]</div>
                </div>
                <div class="right right-align" style="width:50%;">
                    <div>Welcome, <b>{{session('name')}}</b>!</div>
                    <a href="{{URL('logout')}}"><small><i class="fa fa-power-off"></i> Logout</small></a>
                </div>
                <div style="clear:both;"></div>
            </div>

            <div class="body">
                <div class="body-row row">
                    <div class="menu-list col m2 l2 s12" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
                        <a href="#" data-activates="slide-out" data-sidenav="right" data-menuwidth="250" class="mobile-menu-list hide-on-med-and-up">
                            <i class="fa fa-bars fa-2x"></i>
                        </a>
                        <div class="desktop-menu-list hide-on-small-and-down">
                            <a href="{{URL('dashboard')}}">
                                <div class="menu">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </div>
                            </a>

                            <div class="menu-disabled"><b>Sales</b></div>
                            <a href="{{URL('sales_add')}}">
                                <div class="menu">
                                    <i class="fa fa-list-alt"></i> Make Order
                                </div>
                            </a>

                            <a href="{{URL('sales_pending')}}">
                                <div class="menu">
                                    <i class="fa fa-question-circle"></i> Pending Order
                                </div>
                            </a>

                            <a href="{{URL('sales_complete')}}">
                                <div class="menu">
                                    <i class="fa fa-check-square"></i> Complete Order
                                </div>
                            </a>

                            <a href="{{URL('sales_report')}}">
                                <div class="menu">
                                    <i class="fa fa-file-o"></i> Report
                                </div>
                            </a>

                            <div class="menu-disabled"><b>Purchases</b></div>

                            <a href="{{URL('purchase_add')}}">
                                <div class="menu">
                                    <i class="fa fa-list-alt"></i> Make Order
                                </div>
                            </a>

                            <a href="{{URL('purchase_pending')}}">
                                <div class="menu">
                                    <i class="fa fa-question-circle"></i> Pending Order
                                </div>
                            </a>

                            <a href="{{URL('purchase_complete')}}">
                                <div class="menu">
                                    <i class="fa fa-check-square"></i> Complete Order
                                </div>
                            </a>

                            <a href="{{URL('purchase_report')}}">
                                <div class="menu">
                                    <i class="fa fa-file-o"></i> Report
                                </div>
                            </a>

                            <div class="menu-disabled"><b>Products</b></div>
                            @if(session('role') == 'admin')
                            <a href="{{URL('products_add')}}">
                                <div class="menu">
                                    <i class="fa fa-plus-circle"></i> Add New Product
                                </div>
                            </a>

                            <a href="{{URL('products')}}">
                                <div class="menu">
                                    <i class="fa fa-list"></i> List of Products
                                </div>
                            </a>
                            @endif

                            <a href="{{URL('products_report')}}">
                                <div class="menu">
                                    <i class="fa fa-file-o"></i> Report
                                </div>
                            </a>

                            @if(session('role') == 'admin')
                            <div class="menu-disabled"><b>Suppliers</b></div>
                            <a href="{{URL('suppliers_add')}}">
                                <div class="menu">
                                    <i class="fa fa-plus-circle"></i> Add New Supplier
                                </div>
                            </a>

                            <a href="{{URL('suppliers')}}">
                                <div class="menu">
                                    <i class="fa fa-list"></i> List of Suppliers
                                </div>
                            </a>
                            @endif
                            
                            <div class="menu-disabled"><b>Customers</b></div>

                            <a href="{{URL('customers_add')}}">
                                <div class="menu">
                                    <i class="fa fa-plus-circle"></i> Add New Customer
                                </div>
                            </a>

                            <a href="{{URL('customers')}}">
                                <div class="menu">
                                    <i class="fa fa-list"></i> List of Customers
                                </div>
                            </a>
                            
                            @if(session('role') == 'admin')
                            <div class="menu-disabled"><b>Ingredients & Categories</b></div>
                            <a href="{{URL('ingredients')}}">
                                <div class="menu">
                                    <i class="fa fa-list"></i> List of Ingredients
                                </div>
                            </a>

                            <a href="{{URL('categories')}}">
                                <div class="menu">
                                    <i class="fa fa-list"></i> List of Categories
                                </div>
                            </a>
                            @endif
                            
                            <div class="menu-disabled"><b>Others</b></div>
                            @if(session('role') == 'admin')
                            <a href="{{URL('accounts')}}">
                                <div class="menu">
                                    <i class="fa fa-users"></i> Accounts
                                </div>
                            </a>
                            @endif

                            <a href="{{URL('settings')}}">
                                <div class="menu">
                                    <i class="fa fa-gear"></i> Settings
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="content-area col m10 l10 s12" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        {!! Html::script('js/jquery.js') !!}
        {!! Html::script('js/chart.js') !!}
        {!! Html::script('js/swal.js') !!}
        {!! Html::script('js/nicescroll.js') !!}
        {!! Html::script('js/moment.js') !!}
        {!! Html::script('js/materialize.min.js') !!}
        {!! Html::script('js/angular.js') !!}
        {!! Html::script('js/angular.materialize.js') !!}
        {!! Html::script('js/angular-swal.js') !!}
        {!! Html::script('js/angular-nicescroll.js') !!}
        {!! Html::script('js/angular-chart.js') !!}
        {!! Html::script('js/angular-module.js') !!}
        {!! Html::script('js/controllers/homeController.js') !!}
    </body>
</html>