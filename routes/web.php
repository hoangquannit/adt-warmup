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

Route::group([
    'namespace' => 'Admin',
    'middleware' => ['web']
],
    function () {
        Route:: get('/post', ['as'=> 'post_index','uses'=> 'PostController@index']);
        Route:: post('/store', ['as'=> 'post_store','uses'=> 'PostController@store']);
        Route:: get('/posts', ['as'=> 'post_list','uses'=> 'PostController@listPost']);
        Route::get('/auth/{provider}', ['as' => 'login', 'uses' => 'SocialAuthController@redirect']);
        Route::get('/auth/{provide}/callback', 'SocialAuthController@handleProviderCallback');
        Route::get('/logout', ['as' => 'logout', 'uses' => 'HomeController@logout'])->middleware('auth');
        Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index'])->middleware('auth');
        Route::post('/update/profile', ['as' => 'store', 'uses' => 'HomeController@store'])->middleware('auth');
        Route::post('/user/avatar', ['as' => 'avatar', 'uses' => 'HomeController@editAvatar'])->middleware('auth');
        Route:: get('/post/{id}',['as'=> 'edit_post','uses'=> 'PostController@edit']);
        Route:: post('/post/{id}',['as'=> 'update_post','uses'=> 'PostController@update']);
        Route:: get('/post/delete/{id}',['as'=> 'delete_post','uses'=> 'PostController@delete']);
    }
);