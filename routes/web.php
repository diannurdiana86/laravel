<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Modules\Auth\RoleController;
use App\Http\Controllers\Modules\Auth\UserController;
use App\Http\Controllers\Modules\Product\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('auth/roles', RoleController::class, ['as' => 'auth']);
Route::resource('auth/users', UserController::class, ['as' => 'auth']);
Route::resource('master/products', ProductController::class, ['as' => 'master']);
