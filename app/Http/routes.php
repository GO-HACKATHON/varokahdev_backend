<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'api', 'namespace' => 'Api'] , function() {
    /*----------  Auth  ----------*/
    Route::post('auth/login','AuthController@login');
    Route::post('auth/register','AuthController@register');

    Route::group(['middleware' => 'auth:api'], function() {
        /* Api List service */
        Route::get('service','ServiceController@index');
        Route::get('service/{id}/agent','ServiceController@showAgent');

        Route::post('order','OrderController@order');
        Route::get('order/{order_id}/show','OrderController@show');

        Route::group(['middleware' => 'role:agent' ], function() {
              Route::post('order/{order_id}/take','OrderController@takeOrder');
              Route::post('order/{order_id}/done','OrderController@doneOrder');
        });

        Route::post('users/set-location','UserController@setLocation');
        Route::post('agent/{id}/set-location','AgentController@setLocation');

    });




});

Route::auth();

Route::get('/home', 'HomeController@index');



Route::group(['middleware' => 'role:admin'], function () {
    Route::get('admin', function() {
        return 'Hallo admin';
    });
});
