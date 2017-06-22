@extends('template/index')
@section('title', 'Point Of Sales')
@section('content')

<div class="index-container" ng-controller="indexController">
    <div class="title">
        <span class="company-name"></span> Point of Sales
    </div>
    <div class="login-form">
        <span style="font-size:2em;">Login</span>
        {!! Form::open(['id' => 'login-form', 'url' => 'userLogin', 'ng-submit' => 'Login($event)']) !!}
        <div class="input-field">
            <i class="fa fa-id-badge prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_username" name="login-username" type="text" class="validate" ng-model="loginUsername">
            <label for="icon_username">Username</label>
            @if($errors->has('login-username'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('login-username') . ')</div>'; ?>
            @endif
        </div>
        <div class="input-field">
            <i class="fa fa-lock prefix" style="top:15px;"></i>
            <input id="icon_password" name="login-pass" type="password" class="validate" ng-model="loginPass">
            <label for="icon_password">Password</label>
            @if($errors->has('login-pass'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('login-pass') . ')</div>'; ?>
            @endif
        </div>
        <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">' . session("error") . '</div>' ?>
        <i class="login-btn btn waves-effect waves-light">
            <input class="waves-button-input" type="submit" value="Enter" style="width:100%;height:100%;"/>
        </i>
        <div style="padding:10px;"></div>
        {!! Form::close() !!}
    </div>
    <div class="copyright center-align">
        &copy; {{date('Y', time())}} Point of Sales.
    </div>
</div>

@stop
