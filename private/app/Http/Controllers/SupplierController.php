<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use App\Supplier;
use DB;
use Redirect;
use Input;

class SupplierController extends Controller {

    public function addNewSupplier(SupplierRequest $request) {
        $name = Input::get('supplier-name');
        $address = Input::get('supplier-address');
        $phone = Input::get('supplier-phone');
        $email = nput::get('supplier-email');

        Supplier::addNewSupplier($name, $address, $phone, $email);
        return Redirect::to('suppliers_add')->with('successSupplier', 'Supplier has been added!');
    }

    public function editSupplier(SupplierRequest $request) {
        $id = Input::get('supplier-id');
        $name = Input::get('supplier-name');
        $address = Input::get('supplier-address');
        $phone = Input::get('supplier-phone');
        $email = Input::get('supplier-email');

        Supplier::editSupplier($id, $name, $address, $phone, $email);
        return Redirect::to('suppliers_edit/' . $id)->with('successSupplier', 'Supplier has been edited!');
    }

    public function removeSupplier() {
        $id = Input::get('id');
        $result = Supplier::removeSupplier($id);
        
        if ($result)
            echo "success";
        else
            echo "error";
    }

}
