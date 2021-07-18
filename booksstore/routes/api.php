<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\HelpController;
use \App\Http\Controllers\Api\HelpController2;
use \App\Http\Controllers\Api\HelpController3;
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
/**
Route::get('api/products',[HelpController::class, 'index'] );
Route::get('api/products/{id}',[HelpController::class, 'show'] );
Route::get('api/products?category={id}',[HelpController3::class, 'show'] );*/
//Route::get('api/category/{id}',[HelpController3::class, 'show'] );
//Route::apiResources('api/cart/add',[HelpController2::class, 'store'] );
Route::apiResources([
    'products'=>HelpController::class,
    'cart'=>HelpController2::class,
    'cart/add'=>HelpController2::class,
    'cart/update'=>HelpController2::class,
    //'cart/add'=>HelpController2::class,
   // 'category'=>HelpController3::class,
]);
