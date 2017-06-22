<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Mail;

class User extends Model {

    protected $table = 'user';
    public $incrementing = false;
    public $primarykey = 'username';
    public $timestamps = false;

    public static function login($username, $password) {
        $user = User::select('username', 'password', 'name', 'email', 'phone', 'role', 'token', 'created')
                ->where(['username' => $username])
                ->get();

        if (count($user) > 0) {
            if (Hash::check($password, $user[0]['password']))
                return $user;
            else
                return "0";
        } else
            return "0";
    }

    public static function getCustomerByUsername($username) {
        $customer = User::select('username', 'name')
                ->where([
                    ['username', '=', $username],
                    ['role', '=', 'customer']
                ])
                ->limit(1)
                ->get();

        return $customer;
    }

    public static function getCustomers($offset, $sv, $sc) {
        if (is_null($sv) && is_null($sc)) {
            $customers = User::where('role', '=', 'customer')
                            ->orderBy('name')
                            ->offset($offset)->limit(10)->get();
        } else {
            $customers = User::where([
                                [$sc, 'like', '%' . $sv . '%'],
                                ['role', '=', 'customer']
                            ])
                            ->orderBy('name')
                            ->offset($offset)->limit(10)->get();
        }
        return $customers;
    }

    public static function getCustomerData($username) {
        $customer = User::where('username', '=', $username)->get();
        return $customer;
    }

    public static function addNewCustomer($username, $password, $name, $email, $phone, $token) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $customer = new User;
                $customer->username = $username;
                $customer->password = $password;
                $customer->name = $name;
                $customer->email = $email;
                $customer->phone = $phone;
                $customer->role = 'customer';
                $customer->token = $token;
                $customer->save();

                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function editCustomer($username, $name, $email, $phone) {
        if (User::checkToken(session('username'), session('token'))) {
            User::where('username', '=', $username)
                    ->update([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone
            ]);
        }
    }

    public static function removeCustomer($username) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $customer = User::where('username', '=', $username)->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function countCustomers() {
        $count = User::selectRaw('COUNT(username) AS total')->where('role', '=', 'customer')->get();
        return $count[0]->total;
    }

    public static function getSystemAccounts() {
        $accounts = User::where([
                    ['role', '<>', 'customer'],
                    ['username', '<>', session('username')]
                ])->get();
        return $accounts;
    }

    public static function addNewAccount($username, $password, $name, $email, $phone, $role) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $user = new User;
                $user->username = $username;
                $user->password = bcrypt($password);
                $user->name = $name;
                $user->email = $email;
                $user->phone = $phone;
                $user->role = $role;
                $user->token = bcrypt($username);

                $user->save();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function removeAccount($username) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $user = User::where('username', '=', $username)->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                echo $e->getMessage();
                return false;
            }
        } else
            return false;
    }

    public static function checkOldPassword($username, $oldPass) {
        $user = User::select('password')
                ->where('username', '=', $username)
                ->get();

        if (Hash::check($oldPass, $user[0]['password']))
            return true;
        else
            return false;
    }

    public static function changePassword($username, $newPass) {
        if (User::checkToken(session('username'), session('token'))) {
            User::where('username', '=', $username)->update(['password' => bcrypt($newPass)]);
            return true;
        } else
            return false;
    }

    public static function checkToken($username, $token) {
        $result = User::selectRaw('1')
                        ->where([
                            ['username', '=', $username],
                            ['token', '=', $token]
                        ])->get();
        if (count($result) > 0)
            return true;
        else
            return false;
    }

}
