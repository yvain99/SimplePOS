@extends('template/home')
@section('title', 'Point Of Sales - Products Report')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="product-header">
        <div class="input-field product-search-input" style="margin-top:10px;width:10em;">
            <label for="products-report-start-date">Start Date</label>
            <input input-date
                   type="text"
                   id="products-report-start-date"
                   name="products-report-start-date"
                   ng-model="reportStartTime"
                   container=""
                   format="yyyy-mm-dd"
                   months-full="[[datePickerMonth]]"
                   months-short="[[datePickerMonthShort]]"
                   weekdays-full="[[datePickerWeekdaysFull]]"
                   weekdays-short="[[datePickerWeekdaysShort]]"
                   weekdays-letter="[[datePickerWeekdaysLetter]]"
                   disable="disable"
                   today="today"
                   first-day="1"
                   clear="clear"
                   close="close"
                   select-years="15"/>
        </div>
        <div class="input-field product-search-input" style="margin-top:10px;width:10em;">
            <label for="products-report-end-date">End Date</label>
            <input input-date
                   type="text"
                   id="products-report-end-date"
                   name="products-report-end-date"
                   ng-model="reportEndTime"
                   container=""
                   format="yyyy-mm-dd"
                   months-full="[[datePickerMonth]]"
                   months-short="[[datePickerMonthShort]]"
                   weekdays-full="[[datePickerWeekdaysFull]]"
                   weekdays-short="[[datePickerWeekdaysShort]]"
                   weekdays-letter="[[datePickerWeekdaysLetter]]"
                   disable="disable"
                   first-day="1"
                   select-years="15"/>
        </div>
        <div class="input-field product-search-input">
            <label class="active" for="products-report-category">Category</label>
            <select id="products-report-category">
                <option value="sold_qty">Sold Qty</option>
                <option value="sold_price">Sold Price</option>
            </select>
        </div>
        <button class="product-search-input" style="height:50px;position:relative;top:-5px;" ng-click="generateProductsReport()">
            <i class="fa fa-gears"></i> Generate
        </button>
        <button class="product-search-input" style="height:50px;position:relative;top:-5px;" ng-click="printProductsReport()">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
    <div id="products-report-content">
        
    </div>
</div>
@stop
