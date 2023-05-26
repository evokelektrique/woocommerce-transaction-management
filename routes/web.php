<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountsController;
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
Route::get('/token', [HomeController::class, "token"])->name("home.token");

Auth::routes();

Route::get("/register", function () {
    abort(403);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/{order}/update_support_note', [OrderController::class, "update_support_note"])->name("order.update_support_note");
});

Route::prefix('notes')->group(function () {
    Route::get('/{order}', [NoteController::class, "show"])->name("note.show");
    Route::post('/store/{order}', [NoteController::class, "store"])->name("note.store");
    Route::delete('/destroy/{note}', [NoteController::class, "destroy"])->name("note.destroy");
});

Route::prefix('customers')->group(function () {
    Route::get('/{customer}', [CustomerController::class, "show"])->name("customer.show");
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountsController::class, 'index'])->name('account.index');
    Route::get('/{account}', [AccountsController::class, 'show'])->name('account.show');
});
