@extends('template/home')
@section('title', 'Point Of Sales - Purchase Report')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="purchase-header">
        <div class="input-field purchase-search-input" style="margin-top:10px;width:10em;">
            <label for="purchase-report-start-date">Start Date</label>
            <input input-date
                   type="text"
                   id="purchase-report-start-date"
                   name="purchase-report-start-date"
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
        <div class="input-field purchase-search-input" style="margin-top:10px;width:10em;">
            <label for="purchase-report-end-date">End Date</label>
            <input input-date
                   type="text"
                   id="purchase-report-end-date"
                   name="purchase-report-end-date"
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
        <button class="purchase-search-input" style="height:50px;position:relative;top:-5px;" ng-click="generatePurchaseReport()">
            <i class="fa fa-gears"></i> Generate
        </button>
        <button class="purchase-search-input" style="height:50px;position:relative;top:-5px;" ng-click="printPurchaseReport()">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
    <div id="purchase-report-content">
        
    </div>
</div>
@stop
