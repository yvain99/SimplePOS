@extends('template/home')
@section('title', 'Point Of Sales - Dashboard')
@section('content')

<div class="dashboard-selling">
    <div class="dashboard-btn">
        <a href="{{URL('sales_add')}}"><i class="fa fa-plus-circle"></i> Make New Order</a>
    </div>
    <div class="dashboard-title">Pending Orders</div>
    <div class="dashboard-content">
        <div class="row" style="margin:0;">
            @if(count($pendingSales) > 0)
            @foreach($pendingSales as $pendingSale)
            <a href="{{URL('sales_pending/'.$pendingSale->id)}}">
                <div class="col m2 l2 s12" style="padding:5px;">
                    <div class="dashboard-pending-order">
                        <div class="dashboard-pending-order-description">{{$pendingSale->description}}</div>
                        <div class="dashboard-pending-order-total-qty"><b>Qty:</b> {{number_format($pendingSale->total_qty)}}</div>
                        <div class="dashboard-pending-order-total-price"><b>Total:</b> {{number_format($pendingSale->total)}}</div>
                    </div>
                </div>
            </a>
            @endforeach
            @else
            <div class="dashboard-selling-empty" style="padding:10px;">No Pending Orders Yet.</div>
            @endif
        </div>
    </div>
</div>

<div class="dashboard-products">
    <div class="dashboard-btn">
        <a href="{{URL('purchase_add')}}"><i class="fa fa-plus-circle"></i> Make New Order</a>
    </div>
    <div class="dashboard-title">Products Alert</div>
    <div class="dashboard-content">
        <div style="padding:10px;" ng-show="dproductsEmpty">No Alerts Yet.</div>
        <div ng-show="dproductsBox" class="dashboard-products-warning-box red-text">
            <b>Following products or ingredients nearly out of stock:</b>
            <div class="row" style="font-size:0.95em;margin:5px 0 0 0;">
                <div class="col m2 l2 s6" ng-repeat="dproductAlert in dproductsAlert">
                    <i class="fa fa-chevron-right"></i> [[dproductAlert.name]] ([[dproductAlert.qty + ' ' + dproductAlert.unit_name]]) left.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-selling-stats">
    <div class="dashboard-title">Financial Report</div>
    <div class="dashboard-content row">
        <div class="dashboard-chart col m6 l6 s12">
            <div class="dashboard-title center-align"><small>Selling & Purchasing This Week</small></div>
            <canvas id="line" 
                    class="chart chart-line" 
                    chart-data="data" 
                    chart-labels="labels" 
                    chart-series="series"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
        <div class="dashboard-chart-details col m6 l6 s12">
            <div class="dashboard-title center-align"><small>Year {{$year}} Details</small></div>
            <div class="row center-align">
                <div class="col m6 l6 s12">
                    <b>Cost of goods sold</b> <br/> {{number_format($details['cogs'])}}
                </div>
                <div class="col m6 l6 s12">
                    <b>Turnover</b> <br/> {{number_format($details['turnover'])}}
                </div>
                <div class="col m12 l12 s12">
                    <b>Profit</b> <br/> {{number_format($details['turnover'] - $details['cogs'])}}
                </div>
            </div>


        </div>
        <div style="clear:both;"></div>
    </div>
</div>

<div class="dashboard-additional-info">
    <div class="dashboard-title">Additional Information</div>
    <div class="row center-align">
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Products Registered</div>
            <div style="font-size:1.2em;">{{number_format($additionals['products'])}}</div>
        </div>
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Ingredients Registered</div>
            <div style="font-size:1.2em;">{{number_format($additionals['ingredients'])}}</div>
        </div>
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Customers Registered</div>
            <div style="font-size:1.2em;">{{number_format($additionals['customers'])}}</div>
        </div>
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Suppliers Registered</div>
            <div style="font-size:1.2em;">{{number_format($additionals['suppliers'])}}</div>
        </div>
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Complete Sales</div>
            <div style="font-size:1.2em;">{{number_format($additionals['sales'])}}</div>

        </div>
        <div class="col m3 l3 s6 z-depth-1">
            <div style="font-size:1.2em;font-weight:bold;">Complete Purchases</div>
            <div style="font-size:1.2em;">{{number_format($additionals['purchases'])}}</div>    
        </div>
    </div>
</div>

@stop
