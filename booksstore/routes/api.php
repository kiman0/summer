<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MainController;
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

/**  Остальные Роуты прописаны  в файле web.php */

Route::post('cart/update', [HelpController2::class, 'update']);
Route::post('cart/add', [HelpController2::class, 'store']);
Route::post('cart/submit', [HelpController2::class, 'submit']);
Route::post('cart/delete', [HelpController2::class, 'destroy']);

//Route::get('/cart', [HelpController2::class, 'index']);

//Route::get('auth:api')->get('/cart');

Route::apiResources([
    /** Метод для получения товара по ID есть в laravel уже  */
    'products' => HelpController::class,
    'cart' => HelpController2::class,

]);
