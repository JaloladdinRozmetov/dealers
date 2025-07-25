<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfflineCounterController;
use App\Http\Controllers\StatisticController;
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
Route::get('/scann',function(){
    return view('index');
});
Route::middleware(['auth','admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'users'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/{user}/show', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
//Route::get('/offline-counters', [OfflineCounterController::class, 'index'])->middleware(['auth','admin'])->name('offline_counters.index');
Route::get('/counters/{hash}', [OfflineCounterController::class, 'show'])->name('offline_counters.show');
Route::get('/user-counter/{serial_number}', [OfflineCounterController::class, 'showByQrCode'])->name('offline_counters.show.Qr-code');
Route::middleware(['auth','admin'])->prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/export-offline-counters', [OfflineCounterController::class, 'export'])->name('offline_counters.export');

});

Route::middleware(['auth','admin'])->prefix('counters')->group(function () {
//    Route::get('/counters/search', [CounterController::class, 'search'])->name('counters.search');
    Route::get('/counters/import', [CounterController::class, 'counterImport'])->name('counters.import');
    Route::post('/counters/import', [CounterController::class, 'import'])->name('import.excel');
    Route::get('/', [CounterController::class, 'index'])->name('counters');
    Route::get('/statistics', [StatisticController::class, 'statistics'])->name('counters.statistics');
    Route::get('/create', [CounterController::class, 'create'])->middleware('admin')->name('counters.create');
    Route::post('/', [CounterController::class, 'store'])->middleware('admin')->name('counters.store');
    Route::get('/{counter}/edit', [CounterController::class, 'edit'])->middleware('admin')->name('counters.edit');
    Route::get('/{counter}/show', [CounterController::class, 'show'])->middleware('admin')->name('counters.show');
    Route::put('/{counter}', [CounterController::class, 'update'])->middleware('admin')->name('counters.update');
    Route::delete('/{counter}', [CounterController::class, 'destroy'])->middleware('admin')->name('counters.destroy');
    Route::put('/{counter}', [CounterController::class, 'remove'])->middleware('admin')->name('counters.remove');
});
Route::post('/sold/counter',[CounterController::class,'soldCounter'])->middleware('auth')->name('sold.counter');

