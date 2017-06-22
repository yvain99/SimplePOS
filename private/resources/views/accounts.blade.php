@extends('template/home')
@section('title', 'Point Of Sales - Accounts')
@section('content')

<div class="accounts-left" ng-nicescroll nice-option="{cursorcolor:'#c0c0c0'}">
    <table class="centered bordered striped" width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($accounts) > 0)
            @foreach($accounts as $account)
            <tr>
                <td>{{$account->username}}</td>
                <td>{{$account->name}}</td>
                <td>{{$account->email}}</td>
                <td>{{$account->phone}}</td>
                <td>{{$account->role}}</td>
                <td style="cursor:pointer;" ng-click="removeAccount('{{$account->username}}');">
                    <i class="fa fa-times"></i>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">No Result(s).</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="accounts-right">
    <h5 style="margin:0;">Add New Account</h5>
    {!! Form::open(['id' => 'add-account-form', 'url' => 'addNewAccount']) !!}
    <div class="row">
        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-id-badge prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_username" name="username" type="text" class="validate" ng-model="username">
                <label for="icon_username">Username</label>
                @if($errors->has('username'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('username') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-lock prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_password" name="password" type="password" class="validate" ng-model="password">
                <label for="icon_password">Password</label>
                @if($errors->has('password'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('password') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_name" name="name" type="text" class="validate" ng-model="name">
                <label for="icon_name">Name</label>
                @if($errors->has('name'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('name') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-envelope prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_email" name="email" type="email" class="validate" ng-model="email">
                <label for="icon_email">Email</label>
                @if($errors->has('email'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('email') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-phone-square prefix" style="font-size:1.5em;top:15px;"></i>
                <input id="icon_phone" name="phone" type="tel" class="validate" ng-model="phone">
                <label for="icon_phone">Phone</label>
                @if($errors->has('phone'))
                <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('phone') . ')</div>'; ?>
                @endif
            </div>
        </div>

        <div class="col m6 l6 s12 center-align">
            <div class="input-field">
                <i class="fa fa-tag fa-lg prefix" style="font-size:1.5em;left:0;top:15px;"></i>
                <select name="role">
                    <option value="employee">employee</option>
                    <option value="admin">admin</option>
                </select>
                <label for="icon_role">Role</label>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="right">
            <i class="btn waves-effect waves-light" style="display:block;width:10em;">
                <input class="waves-button-input" type="submit" value="Submit" style="width:100%;height:100%;"/>
            </i>
        </div>

        @if(session('successAccount'))
        <?php echo '<div style="color:#64dd17;margin-left:20px;">(' . session('successAccount') . ')</div>'; ?>
        @endif
        @if(session('errorAccount'))
        <?php echo '<div style="color:#ff8a80;margin:15px 0 0 20px;">(' . session('errorAccount') . ')</div>'; ?>
        @endif
    </div>
    {!! Form::close() !!}
</div>
@stop
