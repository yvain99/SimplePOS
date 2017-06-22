'use strict';

angular.module('myApp', ['ui.materialize', 'oitozero.ngSweetAlert', 'angular-nicescroll', 'chart.js'])
        .config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('[[').endSymbol(']]');
        });
