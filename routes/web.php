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


Route::get('/product', [
    'uses' => 'productController@viewData'
]);

Route::post('/prod.store', [
    'uses' => 'productController@product',
    'as'=>'prod.store'
]);

Route::get('/product', [productController::class,'product']);


