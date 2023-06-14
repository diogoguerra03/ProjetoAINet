<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;


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

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

Auth::routes([
    'verify' => true,
]);

Route::resource('orders', OrderController::class);

Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);
Route::get('catalog/{slug}', [TshirtImageController::class, 'show'])->name('catalog.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('verified');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [ChangePasswordController::class, 'show'])
        ->name('password.change.show');
    Route::post('/password/change', [ChangePasswordController::class, 'store'])
        ->name('password.change.store');
});

Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('catalog/{slug}/edit', [TshirtImageController::class, 'edit'])->name('catalog.edit');
    Route::delete('catalog/{slug}/delete', [TshirtImageController::class, 'destroy'])->name('catalog.destroy');
});


/*
 *   CARRINHO
 */

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
