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

Route::get('/info', function () {
    phpinfo();
});


Route::get('api/test','Api\\TestController@test');
Route::post('api/user/reg','Api\\TestController@reg');//用户注册
Route::post('api/user/login','Api\\TestController@login');//用户登录
Route::get ('api/user/list','Api\\TestController@userList')->middleware('filter');//用户列表
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * 签名
 */
Route::get('/sign1','TestController@sign1');//用户登录

//Route::post('/test/postman1','Api\TestController@postman1');

Route::get('/test/postamanl','Api\TestController@postamanl')->middleware('fileter','check.token');

Route::get('test/encrypt3','Api\TestController@encrypt3');




