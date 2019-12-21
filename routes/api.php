<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

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




Route::post('login', 'UserController@login');

Route::group(['middleware' => 'auth:api'], function()
{
    Route::post('/inserir', 'APIController@index')->name('inserir');
    Route::post('details', 'UserController@details');
});
