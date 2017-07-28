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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@homePage')->middleware('auth');

//Route to admin panel
Route::get('/admin_panel', 'UserController@adminPanel')->middleware('auth');

//Route to add new user
Route::post('/admin_panel/add_user', 'UserController@addUser')->middleware('auth');

//Ajax route to viewing user data via modal
Route::post('/admin_panel/user/{id}', 'UserController@adminViewUser')->middleware('auth');

//Ajax route to update user data
Route::post('/admin_panel/user/update/{id}', 'UserController@adminUpdateUser')->middleware('auth');

// Ajax route to update user acct data
Route::post('/admin_panel/user/updateacct/{id}', 'UserController@adminUpdateUserAcct')->middleware('auth');

//Ajax rout to pull up a dynamic payroll modal
Route::post('/admin_panel/user/payroll/{id}', 'UserController@getPayrollForm')->middleware('auth');

//Test Ajax
Route::post('/admin/contribCheck', 'PayrollsController@contribCheck')->middleware('auth');

//Processes and calculates data submitted via ajax
Route::post('/admin_panel/payroll_update', 'PayrollsController@payrollUpdate')->middleware('auth');

//Saves payroll data and uploads to db
Route::post('/admin_panel/save_payroll/{id}', 'PayrollsController@payrollSave')->middleware('auth');

//Route to view user's payroll
Route::get('/payroll', 'PayrollsController@payroll')->middleware('auth');

//Retrive chosen payroll from database
Route::post('/payroll/view', 'PayrollsController@viewPayroll')->middleware('auth');