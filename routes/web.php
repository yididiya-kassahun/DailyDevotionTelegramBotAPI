<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [
    'uses' => 'todoController@home'
]);

Route::post('/todo', [
    'uses' => 'todoController@myToDoList',
    'as' => 'todo.post'
]);

Route::get('delete.todo/{id}',[
    'uses'=>'todoController@deleteToDo',
    'as'=>'delete.todo'
]);

Route::get('update.todo/{id}',[
    'uses'=>'todoController@updateToDo',
    'as'=>'update.todo'
]);
// Route::get('/home' ,[
//     'uses' => 'homeController@homeView',
//     'as' => 'home'
// ]);

// Route::post('/postItem', [
//     'uses' => 'homeController@postItem',
//     'as' => 'postItem'
// ]);
