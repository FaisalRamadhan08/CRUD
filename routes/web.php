<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('/welcome');
});

// Dashboard
Route::get('/', [DashboardController::class, 'indexPage']);
Route::get('/dashboard', [DashboardController::class, 'indexPage']);

// User
// Route::get('/user', [UserController::class, 'indexPage']);
Route::get('/user', [UserController::class, 'indexPage']);
Route::post('/store', [UserController::class, 'store']);
Route::post('/edit', [UserController::class, 'edit']);
Route::delete('/user/{id}', [UserController::class, 'softDelete'])->name('user.softDelete');

Route::get('/user/detail/{id}', [UserController::class, 'detail']);
Route::post('/user/toggle-status/{id}', [UserController::class, 'toggleStatus']);



// Route::controller(UserController::class)->prefix('user')->group(function () {
//     Route::get('', 'indexPage')->name('user');
//     Route::get('create', 'add')->name('user.create');
//     Route::post('create', 'create')->name('user.add.create');
// });
