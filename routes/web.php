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

Route::get('cnpj/{cnpj}', 'IndexController@getJson');

Route::post('quote', 'IndexController@getQuote')->name('quote');
Route::get('quote3', 'IndexController@getQuote2')->name('quote3');

Route::get('quote2', 'IndexController@testApi')->name('quote2');