<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;
use Redirect;
use Input;
use File;

class SettingsController extends Controller {

    public function updateSettings(SettingsRequest $request) {
        $content = array(
            'name' => Input::get('settings-name'),
            'address' => Input::get('settings-address'),
            'phone' => Input::get('settings-phone'),
            'receipt_text' => nl2br(Input::get('settings-receipt-text'))
        );
        $content = json_encode($content);
        File::put('js/json/settings.json', $content);
        return Redirect::to('settings')->with('successSettings', 'Settings has been updated!');
    }

}
