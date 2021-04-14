<?php

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// >>>>>>>>>>>>>> Auth API  <<<<<<<<<<<<<<<<<<

Route::post('/admin.signup',[
    'uses'=> 'AuthController@adminSignUp',
    'as'=>'admin.signup'
]);

Route::post('/admin.signin',[
    'uses'=> 'AuthController@adminSignIn',
    'as'=>'admin.signin'
]);

// >>>>>>>>>>>>>>> Bot API Routes <<<<<<<<<<<<<

Route::get('/getMembers', [
   'uses' => 'telegramController@getMembers'
]);

Route::get('/getDevotions',[
   'uses'=>'telegramController@getPosts'
]);

Route::post('/addToken',[
    'uses'=> 'telegramController@addToken',
    'as'=> 'addToken'
]);

Route::post('/getMessages', [
    'uses' => 'telegramController@getMessages',
]);

Route::post('/postMessage', [
    'uses' => 'telegramController@sendMessage'
]);

Route::get('/recentPosts',[
    'uses' => 'telegramController@recentPosts'
]);

Route::get('/countMembers', [
    'uses' => 'telegramController@countMembers'
]);

Route::get('/countDevotion',[
     'uses' => 'telegramController@countPosts'
]);
