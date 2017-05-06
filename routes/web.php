<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::post('login', 'EmployeeController@validLogin');

Route::get('/attendance', function () {
    return view('attendance');
});

Route::get('/report', function () {
    return view('report');
});

Route::group(['middleware' => ['guest']], function () {

Route::get('products', 'ProductsController@index');
	
Route::get('productType', 'ProductTypeController@index');
Route::post('updateProductType', 'ProductTypeController@updateProductType');
Route::get('getALLProductType','ProductTypeController@getALLProductType');
Route::get('getProductType','ProductTypeController@getProductType');
Route::delete('deleteProductType','ProductTypeController@deleteProductType');

Route::get('vehicle', 'VehicleController@index');
Route::post('updateVehicle', 'VehicleController@updateVehicle');
Route::get('getALLVehicle','VehicleController@getALLVehicle');
Route::get('getVehicle','VehicleController@getVehicle');
Route::delete('deleteVehicle','VehicleController@deleteVehicle');

Route::get('employee', 'EmployeeController@index');
Route::post('updateEmployee', 'EmployeeController@updateEmployee');
Route::get('getALLEmployee','EmployeeController@getALLEmployee');
Route::get('getEmployee','EmployeeController@getEmployee');
Route::delete('deleteEmployee','EmployeeController@deleteEmployee');
Route::get('logout', 'EmployeeController@logout');

Route::get('customer', 'CustomerController@index');
Route::post('updateCustomer', 'CustomerController@updateCustomer');
Route::get('getALLCustomer','CustomerController@getALLCustomer');
Route::get('getCustomer','CustomerController@getCustomer');
Route::delete('deleteCustomer','CustomerController@deleteCustomer');

Route::get('getStat','CommonController@getStat');
Route::get('dashboard', 'CommonController@index');

});