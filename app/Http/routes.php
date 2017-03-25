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

Route::get('/', function () {
    $user= Auth::user();

    dd($user->hasRole('admin'));


});


Route::group(['prefix' => 'api', 'namespace' => 'Api'] , function() {
    /*----------  Auth  ----------*/
    Route::post('auth/login','AuthController@login');
    Route::post('auth/register','AuthController@register');

});

Route::auth();

Route::get('/home', 'HomeController@index');



Route::group(['middleware' => 'role:admin'], function () {
    Route::get('admin', function() {
        return 'Hallo admin';
    });
});
