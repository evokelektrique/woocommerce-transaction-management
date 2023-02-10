<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', [HomeController::class, "index"])->name("home.index");

Auth::routes();

Route::get("/register", function () {
    abort(403);
});

Route::get('/orders', [OrderController::class, 'index'])->name('order.index');

Route::prefix('notes')->group(function () {
    Route::get('/{order}', [NoteController::class, "show"])->name("note.show");
});

Route::prefix('customer')->group(function () {
    Route::get('/{customer}', [CustomerController::class, "show"])->name("customer.show");
});
