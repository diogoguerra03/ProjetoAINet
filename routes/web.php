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
Route::get('catalog/{slug}/image', [TshirtImageController::class, 'getfile'])->name('photo');

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->group(function () {
        // Perfil
        Route::get('/profile/{user}', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{user}/update', [UserController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{user}/deletephoto', [UserController::class, 'deletePhoto'])
            ->name('profile.deletephoto');
    });

    Route::middleware('customer')->group(function () {
        Route::get('/profile/{user}/my-tshirts', [TshirtImageController::class, 'myTshirts'])->name('profile.mytshirts');
        Route::get('profile/{user}/{slug}/edit', [TshirtImageController::class, 'editMyTshirt'])->name('tshirt.edit');
        Route::delete('profile/{user}/{slug}/delete', [TshirtImageController::class, 'destroyMyTshirt'])->name('tshirt.destroy');
        Route::get('/password/change', [ChangePasswordController::class, 'show'])
            ->name('password.change.show');
        Route::post('/password/change', [ChangePasswordController::class, 'store'])
            ->name('password.change.store');

        // Encomenda
        Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
        Route::get('/order-history', [OrderController::class, 'showOrderHistory'])->name('order.history');
    });

    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/customers', [DashboardController::class, 'customers'])->name('dashboard.customers');
        Route::get('/dashboard/employees', [DashboardController::class, 'employees'])->name('dashboard.employees');
        Route::get('/dashboard/admins', [DashboardController::class, 'admins'])->name('dashboard.admins');
        Route::delete('/dashboard/{customer}/delete', [DashboardController::class, 'deleteCustomer'])->name('dashboard.customers.delete');
        Route::put('/dashboard/{customer}/update', [DashboardController::class, 'customerUpdate'])->name('dashboard.customers.update');
        Route::delete('/dashboard/{employee}/delete', [DashboardController::class, 'deleteEmployee'])->name('dashboard.employees.delete');

        // catalog
        Route::get('catalog/{slug}/edit', [TshirtImageController::class, 'edit'])->name('catalog.edit');
        Route::delete('catalog/{slug}/delete', [TshirtImageController::class, 'destroy'])->name('catalog.destroy');
        Route::get('/dashboard/orders/filter', [DashboardController::class, 'filterOrders'])->name('dashboard.filterOrders');
    });

    Route::middleware('employee')->group(function () {
        Route::get('/dashboard/orders', [DashboardController::class, 'showOrders'])->name('dashboard.orders');
        Route::put('/dashboard/orders/{order}/update', [DashboardController::class, 'updateOrder'])->name('dashboard.orders.update');
        Route::get('/dashboard/orders/{order}/details', [DashboardController::class, 'showDetails'])->name('dashboard.orders.details');
    });
});


// Carrinho
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::delete('/cart/{productId}/delete', [CartController::class, 'removeFromCart'])->name('cart.remove');

// pdf invoice
Route::get('/receipt/{orderId}', [OrderController::class, 'viewReceipt'])->name('receipt.view');
Route::get('/receipt/{orderId}/download', [OrderController::class, 'downloadReceipt'])->name('receipt.download');
