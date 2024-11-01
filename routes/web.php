<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\CustomerController;
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




Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
Route::get('/', [CounterController::class,'search'])->middleware('auth')->name('search');
Route::post('/customers', [CustomerController::class, 'store'])->middleware('auth')->name('customers.store');

Route::middleware(['auth','admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'users'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth','admin'])->prefix('counters')->group(function () {
    Route::get('/counters/search', [CounterController::class, 'search'])->name('counters.search');
    Route::get('/counters/import', [CounterController::class, 'counterImport'])->name('counters.import');
    Route::post('/counters/import', [CounterController::class, 'import'])->name('import.excel');
    Route::get('/', [CounterController::class, 'index'])->name('counters');
    Route::get('/create', [CounterController::class, 'create'])->middleware('admin')->name('counters.create');
    Route::post('/', [CounterController::class, 'store'])->middleware('admin')->name('counters.store');
    Route::get('/{counter}/edit', [CounterController::class, 'edit'])->middleware('admin')->name('counters.edit');
    Route::put('/{counter}', [CounterController::class, 'update'])->middleware('admin')->name('counters.update');
    Route::delete('/{counter}', [CounterController::class, 'destroy'])->middleware('admin')->name('counters.destroy');
});
Route::post('/sold/counter',[CounterController::class,'soldCounter'])->middleware('auth')->name('sold.counter');

