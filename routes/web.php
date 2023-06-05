<?php

use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

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

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

Auth::routes([
    'verify' => true,
]);


Route::resource('orders', OrderController::class);

Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);

Route::get('catalog/{product}/{name}', [TshirtImageController::class, 'show'])->name('catalog.show');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');


/*
 *   CARRINHO
 */

Route::get('/cart', [CartController::class, 'store'])->name('cart.store');
