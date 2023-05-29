<?php

use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TshirtImageController;

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
    return view('welcome');
});

//Route::view('/', 'home')->name('root');

Auth::routes([
    'verify' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('orders', OrderController::class);

Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

