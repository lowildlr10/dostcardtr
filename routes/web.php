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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
// Route::get('registration', 'RegistrationController@adduser');

// DTR Module
Route::get('dtr', 'DTRController@showPageDTR');
Route::get('dtr/show-employee', 'DTRController@getEmpList');
Route::get('dtr/show-division/{officeID}', 'DTRController@getDivision');
//Route::get('hash-user-password', 'DTRController@hashUserPasswords');

/* Libraries */


Route::any('print/{type}', 'DocPrintingController@init');
Route::get('sync-bio', 'BiometricsSyncController@syncBiomtricsDB');

Route::get('customRegister','CustomRegisterController@showRegisterForm')->name('custom.customRegister');
Route::post('customRegister','CustomRegisterController@register');

Route::get('customLogin','CustomLoginController@showLoginForm')->name('custom.customLogin');
Route::post('customLogin','CustomLoginController@login');

