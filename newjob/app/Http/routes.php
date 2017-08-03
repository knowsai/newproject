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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('/template/index');
    });
    Route::get('/about', function () {
        return view('/template/about');
    });
    Route::get('/gallery', function () {
        return view('/template/gallery');
    });
    

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});

Route::group(['middleware' => ['web','admin.login'],'prefix' => 'admin','namespace' => 'Admin'], function () {

    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeorder');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::any('upload', 'CommonController@upload');
    Route::resource('links','LinksController');
    Route::post('links/changeorder', 'LinksController@changeorder');
    Route::resource('navs','NavsController');


    Route::any('ad99', 'CategoryController@ad99');
});
