<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

/**  !!!!!!!!!!!!Роуты прописаны в файле api.php!!!!!!!!!
Route::get('/about', [MainController::class, 'parse']);

Route::get('/books/{id}', function () {
    return 'ID';
});
*/
