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
    Reminder::success('Hi! this is Reminder', 'Hello', ["positionClass" => "toast-bottom-right"]);
    return view('welcome');
});

Route::resource('home','Admin\HomeController');
Route::resource('article','Admin\ArticleController');
Route::resource('category','Admin\CategoryController');
Route::resource('tag','Admin\TagController');

//登陆认证
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('login', 'Auth\AuthController@getLogin');

Route::get('logout', 'Auth\AuthController@getLogout');


//注册
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');