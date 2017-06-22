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
    <body ng-app="myApp" style="
          background:url('img/bg.jpg') #f8f8f8 center fixed repeat;
          background-size:cover;
          ">
        @yield('content')

        {!! Html::script('js/jquery.js') !!}
        {!! Html::script('js/chart.js') !!}
        {!! Html::script('js/materialize.min.js') !!}
        {!! Html::script('js/angular.js') !!}
        {!! Html::script('js/angular.materialize.js') !!}
        {!! Html::script('js/angular-swal.js') !!}
        {!! Html::script('js/angular-nicescroll.js') !!}
        {!! Html::script('js/angular-chart.js') !!}
        {!! Html::script('js/angular-module.js') !!}
        {!! Html::script('js/controllers/indexController.js') !!}
    </body>
</html>