<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OrderController;

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

Route::prefix('order')->middleware(["auth:sanctum"])->group(function () {
    Route::post('/create', [OrderController::class, "create"]);
});

Route::prefix('note')->middleware(["auth:sanctum"])->group(function () {
    // Route::post('/create', [NoteController::class, "create"]);
    Route::post('/sync', [NoteController::class, "sync"]);
});
