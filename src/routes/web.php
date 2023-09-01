<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [WorkController::class, 'index']);
    Route::post('/start', [WorkController::class, 'workStart']);
    Route::post('/end', [WorkController::class, 'workEnd']);
    Route::post('/breakstart', [BreakController::class, 'breakStart']);
    Route::post('/breakend', [BreakController::class, 'breakEnd']);
});

Route::get('/attendance', [UserController::class, 'index']);
Route::get('/attendance/{date}', [UserController::class, 'showAllUsers']);
Route::get('/mypage', [UserController::class, 'myPage']);