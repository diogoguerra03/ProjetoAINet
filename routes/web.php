<?php

use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CartController;

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

//Route::view('/', 'home')->name('root');

Auth::routes([
    'verify' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('orders', OrderController::class);

Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);



/*
 *   CARRINHO
 */

// Add a "tshirt" to the cart:
Route::post('cart/{orderItem}', [CartController::class, 'addToCart'])
    ->name('cart.add');
// Remove a "tshirt" from the cart:
Route::delete('cart/{orderItem}', [CartController::class, 'removeFromCart'])
    ->name('cart.remove');
// Show the cart:
Route::get('cart', [CartController::class, 'show'])->name('cart.show');
// Confirm (store) the cart and save tshirts registration on the database:
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
// Clear the cart:
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');