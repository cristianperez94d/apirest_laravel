<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* 
* ROUTES USERS
*/
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit'] ] );
Route::get('/user', 'User\UserController@userData');

/* 
* ROUTES PRODUCTS
*/
Route::resource('products','Product\ProductController', ['except' => ['create', 'edit'] ] );