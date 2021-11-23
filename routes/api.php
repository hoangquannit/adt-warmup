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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'namespace' => 'API',

],
    function () {

        Route:: get('/posts', ['as' => 'post_list', 'uses' => 'PostAPIController@listPost']);
        Route:: post('/create', ['as'=> 'post_store','uses'=> 'PostAPIController@createPost']);
        Route:: put('/update/{id}',['as'=> 'update_post','uses'=> 'PostAPIController@updatePost']);
        Route:: delete('/delete/{id}',['as'=> 'delete_post','uses'=> 'PostAPIController@deletePost']);
    }
);

