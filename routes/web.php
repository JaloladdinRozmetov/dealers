<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

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



Route::get('/',[\App\Http\Controllers\Controller::class,'index'])->middleware('auth')->name('home');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
Route::middleware(['auth','admin'])->prefix('users')->group(function () {

    // Route to view all users
    Route::get('/', [UserController::class, 'users'])->name('users');

    // Route to create a new user
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');

    // Route to edit a user
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');

    // Route to show user details
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

    // Route to delete a user
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
