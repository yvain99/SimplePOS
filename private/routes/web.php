<?php

use App\User;
use App\Sales;
use App\Purchase;
use App\Product;
use App\Supplier;
use App\Ingredient;

Route::get('/', function () {
    if (session('username'))
        return Redirect::to('dashboard');
    else
        return view('index');
});

Route::get('dashboard', function() {
    if (session('username')) {
        $year = date('Y', time());

        $pendingSales = Sales::getPendingSales();

        $details = array(
            'cogs' => Purchase::getCogs($year),
            'turnover' => Sales::getTurnover($year)
        );

        $additionals = array(
            'products' => Product::countProducts(),
            'ingredients' => Ingredient::countIngredients(),
            'customers' => User::countCustomers(),
            'suppliers' => Supplier::countSuppliers(),
            'sales' => Sales::countSales(),
            'purchases' => Purchase::countPurchases()
        );
        return view('dashboard', [
            'pendingSales' => $pendingSales,
            'additionals' => $additionals,
            'details' => $details,
            'year' => $year
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getSellingPurchasing', function() {
    $day = Input::get('day');
    if ($day == 0) {
        $startDay = 6;
        $endDay = 0;
    } else {
        $startDay = $day - 1;
        $endDay = 7 - $day;
    }

    $purchasing = Purchase::getWeekPurchasing($startDay, $endDay);
    $selling = Sales::getWeekSelling($startDay, $endDay);

    $result = array(
        'purchasing' => $purchasing,
        'selling' => $selling
    );

    echo json_encode($result);
});

Route::get('getProductsAlert', function() {
    $result = Product::getProductIngredientsAlert();
    echo json_encode($result);
});

Route::get('sales_add', function() {
    if (session('username')) {
        $salesId = Sales::getNextSalesId();
        $categories = Product::getProductCategories();
        return view('sales_add', [
            'salesId' => $salesId,
            'categories' => $categories
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getSalesAddProducts', function() {
    $category = Input::get('category');
    $products = Product::getSalesAddProducts($category);

    echo json_encode($products);
});

Route::get('getCustomerByUsername', function() {
    $username = Input::get('username');
    $customer = User::getCustomerByUsername($username);

    echo json_encode($customer);
});

Route::get('sales_pending', function() {
    if (session('username')) {
        $sales = Sales::getPendingSales();
        return view('sales_pending', ['salesArr' => $sales]);
    } else
        return Redirect::to('/');
});

Route::get('sales_pending/{id}', function($id) {
    if (session('username')) {
        $categories = Product::getProductCategories();
        $sales = Sales::getSalesData($id);
        return view('sales_edit', [
            'categories' => $categories,
            'sales' => $sales
        ]);
    } else
        return Redirect::to('/');
});

Route::get('sales_complete', function() {
    if (session('username')) {
        $sv = @Input::get('sv');
        $sc = @Input::get('sc');
        $offset = 0;

        $sales = Sales::getCompleteSales(0, $sv, $sc);
        return view('sales_complete', [
            'sales' => $sales,
            'sv' => $sv,
            'sc' => $sc
        ]);
    } else
        return Redirect::to('/');
});

Route::get('sales_complete/{id}', function($id) {
    if (session('username')) {
        $sales = Sales::getSalesData($id);
        return view('sales_complete_preview', ['sales' => $sales]);
    } else
        return Redirect::to('/');
});

Route::get('getMoreCompleteSales', function() {
    $sv = Input::get('sv');
    $sc = Input::get('sc');
    $offset = Input::get('offset');

    $sales = Sales::getCompleteSales($offset, $sv, $sc);
    echo json_encode($sales);
});

Route::get('sales_report', function() {
    return view('sales_report');
});

Route::get('generateSalesReport', function() {
    $startDate = Input::get('startDate');
    $endDate = Input::get('endDate');

    $report = Sales::generateSalesReport($startDate, $endDate);
    echo json_encode($report);
});

Route::get('purchase_add', function() {
    if (session('username')) {
        $purchaseId = Purchase::getNextPurchaseId();
        $suppliers = Supplier::getAllSuppliers();

        return view('purchase_add', [
            'purchaseId' => $purchaseId,
            'suppliers' => $suppliers
        ]);
    } else
        return Redirect::to('/');
});

Route::get('purchase_pending', function() {
    if (session('username')) {
        $purchase = Purchase::getPendingPurchases();
        return view('purchase_pending', ['purchaseArr' => $purchase]);
    } else
        return Redirect::to('/');
});

Route::get('purchase_pending/{id}', function($id) {
    if (session('username')) {
        $suppliers = Supplier::getAllSuppliers();
        $purchase = Purchase::getPurchaseData($id);
        return view('purchase_edit', [
            'suppliers' => $suppliers,
            'purchase' => $purchase
        ]);
    } else
        return Redirect::to('/');
});

Route::get('purchase_complete', function() {
    if (session('username')) {
        $sv = @Input::get('sv');
        $sc = @Input::get('sc');
        $offset = 0;

        $purchase = Purchase::getCompletePurchases(0, $sv, $sc);
        return view('purchase_complete', [
            'purchase' => $purchase,
            'sv' => $sv,
            'sc' => $sc
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getMoreCompletePurchases', function() {
    $sv = Input::get('sv');
    $sc = Input::get('sc');
    $offset = Input::get('offset');

    $purchase = Purchase::getCompletePurchases($offset, $sv, $sc);
    echo json_encode($purchase);
});

Route::get('purchase_complete/{id}', function($id) {
    if (session('username')) {
        $purchase = Purchase::getPurchaseData($id);
        return view('purchase_complete_preview', ['purchase' => $purchase]);
    } else
        return Redirect::to('/');
});

Route::get('getPurchaseAddProducts', function() {
    $sv = Input::get('sv');
    $type = Input::get('type');

    if ($type == "0") //Ingredients
        $result = Product::getPurchaseIngredients($sv);
    else
        $result = Product::getPurchaseProducts($sv);

    echo json_encode($result);
});

Route::get('purchase_report', function() {
    return view('purchase_report');
});

Route::get('generatePurchaseReport', function() {
    $startDate = Input::get('startDate');
    $endDate = Input::get('endDate');

    $report = Purchase::generatePurchaseReport($startDate, $endDate);
    echo json_encode($report);
});

Route::get('products_add', function() {
    if (session('username') && session('role') == 'admin') {
        $categories = Product::getProductCategories();
        return view('products_add', [
            'categories' => $categories
        ]);
    } else
        return Redirect::to('/');
});

Route::get('products_edit/{id}', function($id) {
    if (session('username') && session('role') == 'admin') {
        $product = Product::getProductData($id);
        $categories = Product::getProductCategories();
        $suppliers = Supplier::getAllSuppliers();
        return view('products_edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    } else
        return Redirect::to('/');
});

Route::get('products_edit/{id}/ingredients', function($id) {
    if (session('username') && session('role') == 'admin') {
        $productIngredients = Product::getProductIngredients($id);
        $ingredients = Ingredient::getIngredients();

        return view('products_edit_ingredients', [
            'id' => $id,
            'productIngredients' => $productIngredients,
            'ingredients' => $ingredients
        ]);
    } else
        return Redirect::to('/');
});

Route::get('products', function() {
    if (session('username') && session('role') == 'admin') {
        $sv = @Input::get('sv');
        $sc = @Input::get('sc');
        $offset = 0;

        $products = Product::getProducts(0, $sv, $sc);
        return view('products', [
            'products' => $products,
            'sv' => $sv,
            'sc' => $sc
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getMoreProducts', function() {
    $sv = Input::get('sv');
    $sc = Input::get('sc');
    $offset = Input::get('offset');

    $products = Product::getProducts($offset, $sv, $sc);

    echo json_encode($products);
});

Route::get('products_report', function() {
    return view('products_report');
});

Route::get('generateProductsReport', function() {
    $startDate = Input::get('startDate');
    $endDate = Input::get('endDate');
    $category = Input::get('category');

    $report = Product::generateProductsReport($startDate, $endDate, $category);
    echo json_encode($report);
});

Route::get('suppliers_add', function() {
    if (session('username') && session('role') == 'admin')
        return view('suppliers_add');
    else
        return Redirect::to('/');
});

Route::get('suppliers_edit/{id}', function($id) {
    if (session('username') && session('role') == 'admin') {
        $supplier = Supplier::getSupplierData($id);
        return view('suppliers_edit', ['supplier' => $supplier]);
    } else
        return Redirect::to('/');
});

Route::get('suppliers', function() {
    if (session('username') && session('role') == 'admin') {
        $sv = @Input::get('sv');
        $sc = @Input::get('sc');
        $offset = 0;

        $suppliers = Supplier::getSuppliers(0, $sv, $sc);
        return view('suppliers', [
            'suppliers' => $suppliers,
            'sv' => $sv,
            'sc' => $sc
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getMoreSuppliers', function() {
    $sv = Input::get('sv');
    $sc = Input::get('sc');
    $offset = Input::get('offset');

    $suppliers = Supplier::getSuppliers($offset, $sv, $sc);

    echo json_encode($suppliers);
});

Route::get('customers_add', function() {
    if (session('username'))
        return view('customers_add');
    else
        return Redirect::to('/');
});

Route::get('customers_edit/{username}', function($username) {
    if (session('username')) {
        $customer = User::getCustomerData($username);
        return view('customers_edit', ['customer' => $customer]);
    } else
        return Redirect::to('/');
});

Route::get('customers', function() {
    if (session('username')) {
        $sv = @Input::get('sv');
        $sc = @Input::get('sc');
        $offset = 0;

        $suppliers = User::getCustomers(0, $sv, $sc);
        return view('customers', [
            'customers' => $suppliers,
            'sv' => $sv,
            'sc' => $sc
        ]);
    } else
        return Redirect::to('/');
});

Route::get('getMoreCustomers', function() {
    $sv = Input::get('sv');
    $sc = Input::get('sc');
    $offset = Input::get('offset');

    $customers = User::getCustomers($offset, $sv, $sc);

    echo json_encode($customers);
});

Route::get('ingredients', function() {
    if (session('username') && session('role') == 'admin') {
        $ingredients = Ingredient::getIngredients();
        return view('ingredients', ['ingredients' => $ingredients]);
    } else
        return Redirect::to('/');
});

Route::get('ingredients_add', function() {
    if (session('username') && session('role') == 'admin') {
        $units = Product::getProductUnits();
        return view('ingredients_add', ['units' => $units]);
    } else
        return Redirect::to('/');
});

Route::get('ingredients_edit/{id}', function($id) {
    if (session('username') && session('role') == 'admin') {
        $ingredient = Ingredient::getIngredientData($id);
        $units = Product::getProductUnits();
        return view('ingredients_edit', [
            'ingredient' => $ingredient,
            'units' => $units
        ]);
    } else
        return Redirect::to('/');
});

Route::get('categories', function() {
    if (session('username') && session('role') == 'admin') {
        $categories = Product::getProductCategories();
        $units = Product::getProductUnits();

        return view('categories', [
            'categories' => $categories,
            'units' => $units
        ]);
    } else
        return Redirect::to('/');
});

Route::get('accounts', function() {
    if (session('username') && session('role') == 'admin') {
        $accounts = User::getSystemAccounts();
        return view('accounts', ['accounts' => $accounts]);
    } else
        return Redirect::to('/');
});

Route::get('settings', function() {
    return view('settings');
});

Route::get('logout', function () {
    Session::flush();
    return Redirect::to('/');
});

Route::post('userLogin', 'UserController@userLogin');

//Sales
Route::post('holdCloseSales', 'SalesController@holdCloseSales');
Route::post('holdCloseEditSales', 'SalesController@holdCloseEditSales');

//Purchase
Route::post('holdClosePurchase', 'PurchaseController@holdClosePurchase');

//Products
Route::post('addNewProduct', 'ProductController@addNewProduct');
Route::post('editProduct', 'ProductController@editProduct');
Route::post('removeProduct', 'ProductController@removeProduct');
Route::post('editProductIngredients', 'ProductController@editProductIngredients');

//Suppliers
Route::post('addNewSupplier', 'SupplierController@addNewSupplier');
Route::post('editSupplier', 'SupplierController@editSupplier');
Route::post('removeSupplier', 'SupplierController@removeSupplier');

//Customers
Route::post('addNewCustomer', 'UserController@addNewCustomer');
Route::post('editCustomer', 'UserController@editCustomer');
Route::post('removeCustomer', 'UserController@removeCustomer');

//Ingredients
Route::post('addNewIngredient', 'IngredientController@addNewIngredient');
Route::post('editIngredient', 'IngredientController@editIngredient');
Route::post('removeIngredient', 'IngredientController@removeIngredient');

//Category&Unit
Route::post('addProductCategory', 'ProductController@addProductCategory');
Route::post('removeProductCategory', 'ProductController@removeProductCategory');
Route::post('addProductUnit', 'ProductController@addProductUnit');
Route::post('removeProductUnit', 'ProductController@removeProductUnit');

//Accounts
Route::post('addNewAccount', 'UserController@addNewAccount');
Route::post('removeAccount', 'UserController@removeAccount');

//Settings
Route::post('updateSettings', 'SettingsController@updateSettings');
Route::post('changePassword', 'UserController@changePassword');

// Prevent URL Error (POST)
Route::get('{url}', function() {
    return Redirect::to('/');
})->where('url', 'userLogin|getSalesAddProducts|holdCloseSales|holdCloseEditSales|getMoreCompleteSales|getMoreCompletePurchases|generateSalesReport|generatePurchaseReport|getMoreProducts|addNewProduct|editProduct|removeProduct|generateProductsReport|getMoreSuppliers|addNewSupplier|editSupplier|removeSupplier|addNewCustomer|editCustomer|removeCustomer|getMoreCustomers|addProductCategory|removeProductCategory|addProductUnit|removeProductUnit');
