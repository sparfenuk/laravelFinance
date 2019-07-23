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

Route::get('user',function (){
   return view('userInfo');
});

Route::get('/users','ContentController@users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile','UserController@profile');
Route::post('profile','UserController@update_avatar');

Route::get('/wallet/create','WalletController@create');

Route::post('/wallet/create','WalletController@store');

Route::get('/wallets','WalletController@index');
Route::any('/wallets','WalletController@index')->name('wallets');

Route::get('/currencies','HomeController@getCurrenciesSection');

Route::get('/getLastCurrencies','HomeController@getLastCurrencies')->name('getLastCurrencies');