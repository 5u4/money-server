<?php

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

/* Version 1 */
Route::group(['prefix' => 'v1'], function () {
    /* Auth */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');

        /* Authorization Required */
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('logout', 'AuthController@logout');
        });
    });

    /* User */
    Route::group(['prefix' => 'users'], function () {
        Route::post('/', 'UserController@create');
    });
});
