<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users', 'App\Http\Controllers\UserController@index');
Route::post('users', 'App\Http\Controllers\UserController@create');
Route::delete('users/{userId}', 'App\Http\Controllers\UserController@destroy')
    ->where('userId', '[0-9]+');
Route::put('users/{userId}', 'App\Http\Controllers\UserController@update')
    ->where('userId', '[0-9]+');

Route::post('accounts', 'App\Http\Controllers\AccountController@create');
Route::put('accounts/{accountId}/deposit', 'App\Http\Controllers\AccountController@deposit')
    ->where('accountId', '[0-9]');
