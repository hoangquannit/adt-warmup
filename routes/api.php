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



Route::group([
    'namespace' => 'API',

],
    function () {

        //posts
        Route:: get('/posts', ['as' => 'post_list', 'uses' => 'PostAPIController@listPost']);
        Route:: post('/create', ['as'=> 'post_store','uses'=> 'PostAPIController@createPost']);
        Route:: post('/update/{id}',['as'=> 'update_post','uses'=> 'PostAPIController@updatePost']);
        Route:: delete('/delete/{id}',['as'=> 'delete_post','uses'=> 'PostAPIController@deletePost']);
        Route:: get('/detail/{id}',['as'=> 'post_detail','uses'=> 'PostAPIController@getDetail']);

        //category
        Route:: get('/category', ['as' => 'category_list', 'uses' => 'CategoryAPIController@listCategory']);
        Route:: post('/create', ['as'=> 'category_store','uses'=> 'CategoryAPIController@createCategory']);
        Route:: post('/update/{id}',['as'=> 'update_category','uses'=> 'CategoryAPIController@updateCategory']);
        Route:: delete('/delete/{id}',['as'=> 'delete_category','uses'=> 'CategoryAPIController@deleteCategory']);
        Route:: get('/detail/{id}',['as'=> 'category_detail','uses'=> 'CategoryAPIController@getDetail']);
    }
);

