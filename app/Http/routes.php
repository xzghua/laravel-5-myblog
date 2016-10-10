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



Route::group(['middleware' => 'auth'],function(){

    Route::resource('home','Admin\HomeController');
    Route::resource('article','Admin\ArticleController');
    Route::resource('category','Admin\CategoryController');
    Route::resource('tag','Admin\TagController');

    Route::resource('link','Admin\LinkController');
    Route::resource('seo','Admin\SeoController');
    Route::resource('navigation','Admin\NavigationController');

    Route::get('deleted','Admin\ArticleController@listDeleteArticle');
    Route::get('restore/{id}','Admin\ArticleController@restoreArticle');

    //自动填充标签
    Route::get('autoCompleteTags','Admin\TagController@autoFillTags');

    //评论
    Route::resource('comment','Admin\CommentController');

    Route::get('clearCache','Admin\HomeController@clearRedisCache');

    //退出
    Route::get('logout', 'Auth\AuthController@getLogout');

    Route::post('uploadPhotos','Admin\ArticleController@uploadPhotosByEditor');

    //日志系统
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
    //登陆认证
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('/auth/login', 'Auth\AuthController@getLogin');

//注册
//    Route::get('register', 'Auth\AuthController@getRegister');
//    Route::post('register', 'Auth\AuthController@postRegister');


    Route::get('index','Home\IndexController@index');
    Route::get('/','Home\IndexController@index');
    Route::get("detail/{id}",'Home\IndexController@getDetail');
    Route::get("categories/{cate_name}",'Home\IndexController@getCategories');
    Route::get("tags/{tag_name}",'Home\IndexController@getTags');
    Route::get("about",'Home\IndexController@getAbout');
    Route::get("monthList",'Home\IndexController@getMonthArticle');


    Route::get("testBehavior",'Home\IndexController@getBehavior');

    //评论
    Route::get('getComment','Admin\CommentController@getCallBackComment');
    Route::post('postComment','Admin\CommentController@sync_log');