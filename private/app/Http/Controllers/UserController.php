<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\UserRequest;
use App\User;
use DB;
use Redirect;
use Input;

class UserController extends Controller {

    public function userLogin(LoginRequest $request) {
        $username = Input::get('login-username');
        $pass = Input::get('login-pass');
        $login = User::login($username, $pass);

        if ($login != '0') {
            session([
                'username' => $login[0]['username'],
                'name' => $login[0]['name'],
                'email' => $login[0]['email'],
                'phone' => $login[0]['phone'],
                'role' => $login[0]['role'],
                'token' => $login[0]['token'],
                'created' => date("d F Y, h:i:s A", strtotime($login[0]['created']))
            ]);
            return Redirect::to('dashboard');
        } else
            return Redirect::to('/')->with('error', 'Invalid Username or Password!');
    }

    public function addNewCustomer(CustomerRequest $request) {
        $username = Input::get('customer-username');
        $password = bcrypt(Input::get('customer-password'));
        $name = Input::get('customer-name');
        $email = Input::get('customer-email');
        $phone = Input::get('customer-phone');
        $token = bcrypt($username);

        $result = User::addNewCustomer($username, $password, $name, $email, $phone, $token);

        if ($result)
            return Redirect::to('customers_add')->with('successCustomer', 'Customer has been added');
        else
            return Redirect::to('customers_add')->with('errorCustomer', 'Customer already exists!');
    }

    public function editCustomer(CustomerRequest $request) {
        $username = Input::get('customer-username');
        $name = Input::get('customer-name');
        $email = Input::get('customer-email');
        $phone = Input::get('customer-phone');

        User::editCustomer($username, $name, $email, $phone);
        return Redirect::to('customers_edit/' . $username)->with('successCustomer', 'Customer has been edited!');
    }

    public function removeCustomer() {
        $username = Input::get('username');
        $result = User::removeCustomer($username);

        if ($result)
            echo "success";
        else
            echo "error";
    }

    public function addNewAccount(UserRequest $request) {
        $username = Input::get('username');
        $password = Input::get('password');
        $name = Input::get('name');
        $email = Input::get('email');
        $phone = Input::get('phone');
        $role = Input::get('role');

        $result = User::addNewAccount($username, $password, $name, $email, $phone, $role);

        if ($result)
            return Redirect::to('accounts')->with('successAccount', 'Account has been added');
        else
            return Redirect::to('accounts')->with('errorAccount', 'Account already exists!');
    }

    public function removeAccount() {
        $username = Input::get('username');
        $result = User::removeAccount($username);

        if ($result)
            echo "success";
        else
            echo "error";
    }

    public function changePassword() {
        $username = session('username');
        $oldPass = Input::get('old-password');
        $newPass = Input::get('new-password');

        if (User::checkOldPassword($username, $oldPass)) {
            if (User::changePassword($username, $newPass))
                return Redirect::to('settings')->with('successChangePassword', 'Password has been changed');
        } else
            return Redirect::to('settings')->with('errorChangePassword', 'Incorrect Old Password!');
    }

}
