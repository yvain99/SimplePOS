<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    protected $table = 'supplier';
    public $primarykey = 'id';
    public $timestamps = false;

    public static function getAllSuppliers() {
        $suppliers = Supplier::select('id', 'name')->orderBy('name')->get();
        return $suppliers;
    }

    public static function getSuppliers($offset, $sv, $sc) {
        if (is_null($sv) && is_null($sc))
            $suppliers = Supplier::offset($offset)->limit(10)->get();
        else {
            $suppliers = Supplier::where($sc, 'like', '%' . $sv . '%')->offset($offset)->limit(10)->get();
        }
        return $suppliers;
    }

    public static function getSupplierData($id) {
        $supplier = Supplier::find($id);
        return $supplier;
    }

    public static function addNewSupplier($name, $address, $phone, $email) {
        if (User::checkToken(session('username'), session('token'))) {
            $supplier = new Supplier;
            $supplier->name = $name;
            $supplier->address = $address;
            $supplier->phone = $phone;
            $supplier->email = $email;
            $supplier->save();

            return true;
        } else
            return false;
    }

    public static function editSupplier($id, $name, $address, $phone, $email) {
        if (User::checkToken(session('username'), session('token'))) {
            $supplier = Supplier::find($id);
            $supplier->name = $name;
            $supplier->address = $address;
            $supplier->phone = $phone;
            $supplier->email = $email;

            $supplier->save();
        }
    }

    public static function removeSupplier($id) {
        if (User::checkToken(session('username'), session('token'))) {
            try {
                $supplier = Supplier::find($id);
                $supplier->delete();
                return true;
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else
            return false;
    }

    public static function countSuppliers() {
        $count = Supplier::selectRaw('COUNT(id) AS total')->get();
        return $count[0]->total;
    }

}
