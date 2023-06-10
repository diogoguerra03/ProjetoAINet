<?php

use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;


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

Route::get('/password/change', [ChangePasswordController::class, 'show'])
    ->name('password.change.show');
Route::post('/password/change', [ChangePasswordController::class, 'store'])
    ->name('password.change.store');

Route::resource('orders', OrderController::class);

Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);
Route::delete('catalog/{id}', [TshirtImageController::class, 'destroy'])->name('catalog.destroy');
Route::get('catalog/{slug}', [TshirtImageController::class, 'show'])->name('catalog.show');
Route::get('catalog/{slug}/edit', [TshirtImageController::class, 'edit'])->name('catalog.edit');


Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');


/*
 *   CARRINHO
 */

Route::match(['GET', 'POST'], 'catalog/{id}/{slug}', [CartController::class, 'addToCart'])->name('catalog.addToCart');


// Add a "tshirt" to the cart:
Route::post('cart/add', [CartController::class, 'addToCart'])
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