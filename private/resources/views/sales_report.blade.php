@extends('template/home')
@section('title', 'Point Of Sales - Sales Report')
@section('content')

<div style="position:relative;width:100%;height:100%;">
    <div class="sales-header">
        <div class="input-field sales-search-input" style="margin-top:10px;width:10em;">
            <label for="sales-report-start-date">Start Date</label>
            <input input-date
                   type="text"
                   id="sales-report-start-date"
                   name="sales-report-start-date"
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
        <div class="input-field sales-search-input" style="margin-top:10px;width:10em;">
            <label for="sales-report-end-date">End Date</label>
            <input input-date
                   type="text"
                   id="sales-report-end-date"
                   name="sales-report-end-date"
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
        <button class="sales-search-input" style="height:50px;position:relative;top:-5px;" ng-click="generateSalesReport()">
            <i class="fa fa-gears"></i> Generate
        </button>
        <button class="sales-search-input" style="height:50px;position:relative;top:-5px;" ng-click="printSalesReport()">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
    <div id="sales-report-content">
        
    </div>
</div>
@stop
