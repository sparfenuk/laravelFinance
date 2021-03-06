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

Route::get('/','HomeController@welcome');

Route::get('user',function (){
   return view('userInfo');
});

Route::get('/users','ContentController@users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile','UserController@profile');

Route::patch('profile','UserController@update');

Route::any('/wallets','WalletController@index')->name('wallets');

Route::any('/wallet/{id}','WalletController@show')->name('wallet');

//Route::get('/wallet/create','WalletController@create');

//Route::post('/wallet/create','WalletController@store');

//Route::post('wallet/destroy', 'WalletController@destroy')->name('wallets.destroy');

Route::get('/currencies','HomeController@getCurrenciesSection');

Route::any('getLastCurrencies','HomeController@getLastCurrencies')->name('getLastCurrencies');
