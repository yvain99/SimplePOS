@extends('template/home')
@section('title', 'Point Of Sales - Settings')
@section('content')
<h5 style="margin:0;">Settings</h5>
{!! Form::open(['id' => 'update-settings-form', 'url' => 'updateSettings']) !!}
<div class="row" style="margin-top:10px;">
    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-id-badge prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_settings_name" name="settings-name" type="text" class="validate">
            <label for="icon_settings_name">Company Name</label>
            @if($errors->has('settings-name'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('settings-name') . ')</div>'; ?>
            @endif
        </div>
    </div>
    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-building prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_settings_address" name="settings-address" type="text" class="validate">
            <label for="icon_settings_address">Company Address</label>
            @if($errors->has('settings-address'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('settings-address') . ')</div>'; ?>
            @endif
        </div>
    </div>

    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-phone prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_settings_phone" name="settings-phone" type="text" class="validate">
            <label for="icon_settings_phone">Company Phone</label>
            @if($errors->has('settings-phone'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('settings-phone') . ')</div>'; ?>
            @endif
        </div>
    </div>

    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-font prefix" style="font-size:1.5em;top:15px;"></i>
            <textarea id="icon_settings_receipt_text" name="settings-receipt-text" type="text" class="materialize-textarea"></textarea>
            <label for="icon_settings_receipt_text">Receipt Footer Text</label>
            @if($errors->has('settings-receipt-text'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('settings-receipt-text') . ')</div>'; ?>
            @endif
        </div>
    </div>

    <div class="clearfix"></div>

    @if(session('successSettings'))
    <?php echo '<div style="color:#64dd17;margin:15px 0 0 20px;">(' . session('successSettings') . ')</div>'; ?>
    @endif

    <div class="right">
        <i class="btn waves-effect waves-light" style="display:block;width:10em;">
            <input class="waves-button-input" type="submit" value="Submit" style="width:100%;height:100%;"/>
        </i>
    </div>
</div>
{!! Form::close() !!}

<h5 style="margin:0;">Change Password</h5>
{!! Form::open(['id' => 'change-password-form', 'url' => 'changePassword']) !!}
<div class="row" style="margin-top:10px;">
    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-lock prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_old_password" name="old-password" type="password" class="validate">
            <label for="icon_old_password">Old Password</label>
            @if($errors->has('old-password'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('old-password') . ')</div>'; ?>
            @endif
        </div>
    </div>

    <div class="col m6 l6 s12 center-align">
        <div class="input-field">
            <i class="fa fa-lock prefix" style="font-size:1.5em;top:15px;"></i>
            <input id="icon_new_password" name="new-password" type="password" class="validate">
            <label for="icon_new_password">New Password</label>
            @if($errors->has('new-password'))
            <?php echo '<div style="color:#ff8a80;padding-bottom:20px;">(' . $errors->first('new-password') . ')</div>'; ?>
            @endif
        </div>
    </div>

    <div class="clearfix"></div>

    @if(session('successChangePassword'))
    <?php echo '<div style="color:#64dd17;margin:15px 0 0 20px;">(' . session('successChangePassword') . ')</div>'; ?>
    @endif 
    @if(session('errorChangePassword'))
    <?php echo '<div style="color:#ff8a80;margin:15px 0 0 20px;">(' . session('errorChangePassword') . ')</div>'; ?>
    @endif

    <div class="right">
        <i class="btn waves-effect waves-light" style="display:block;width:10em;">
            <input class="waves-button-input" type="submit" value="Submit" style="width:100%;height:100%;"/>
        </i>
    </div>
</div>
{!! Form::close() !!}
@stop
