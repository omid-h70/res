<?php

use App\Http\Controllers ;
use App\Http\Controllers\Admin ;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| 
| 
| 
|
*/

Route::get('/setup','SetupController@getIndex');
Route::post('/setup','SetupController@postIndex');

Route::group(['middleware'=>['installation']],function(){
    
    Route::get('/', 'IndexController@index');
    Route::get('/index', 'IndexController@index');
    Route::get('/index2', 'IndexController@index2');
    Route::get('/index3', 'IndexController@index3');

    //+++++++++++++++++ create a named route with following syntax
    Route::get('404', [
        'as'   => '404',
        'uses' =>'IndexController@get404'
    ]);

    Route::post('404', 'IndexController@post404');

    Route::controllers([
        'auth'     => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
        'home'     => 'HomeController',
        'article'  => 'ArticleController',
    ]);


    Route::group(['middleware'=>['auth'],'namespace'=>'Admin'], function(){

        Route::group(['prefix'=>'admin'], function(){
            /*
            * 
            */
            Route::controllers([
                'acl'     =>'AclController', 
                'article' =>'ArticleController',
                'food'    =>'FoodController',
                'user'    =>'UserController',
                //'sidebar' =>'SidebarController',
                'setting' =>'SettingController',
            ]);
            /*
            *
            */
        });
        Route::controllers(['admin' =>'AdminController']);
    });

    // Password reset link request routes...
    Route::group(['namespace'=>'Auth'], function(){

        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');

        Route::get('register', 'AuthController@getRegister');
        Route::post('register', 'AuthController@postRegister');

        Route::get('logout', 'AuthController@getLogout');
        Route::post('logout', 'AuthController@postLogout');

        Route::get('password/email', 'PasswordController@getEmail');
        Route::post('password/email', 'PasswordController@postEmail');

        Route::get('password/reset/{token}', 'PasswordController@getReset');
        Route::post('password/reset', 'PasswordController@postReset');

    });

});






