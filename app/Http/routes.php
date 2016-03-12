<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    // Authentication Routes...
    Route::get('/login', 'Auth\AuthController@showLoginForm');
    Route::post('/login', 'Auth\AuthController@login');
    Route::get('/logout', 'Auth\AuthController@logout');

    // Registration Routes...
    Route::get('/register', ['uses' => 'Auth\AuthController@showRegistrationForm', 'as' => 'register']);
    Route::post('/register', 'Auth\AuthController@register');

});



Route::group(
    ['middleware' => ['web']], function () {


    /**
     * Home Controller
    */
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');
    Route::get('/products', 'ProductsController@index');

});

/**
 * Auth\Auth Controller
 */
Route::get('/logout', ['uses' => 'Auth\AuthController@logout', 'as' => 'logout']);