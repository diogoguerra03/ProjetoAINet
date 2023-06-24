<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\LaravelSMTPConfiguration;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TshirtImageController;
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

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/about', function () {
    return view('about');
});

Auth::routes([
    'verify' => true,
]);


Route::resource('customers', CustomerController::class);

Route::resource('catalog', TshirtImageController::class);
Route::get('catalog/{slug}', [TshirtImageController::class, 'show'])->name('catalog.show');
Route::get('catalog/{slug}/image', [TshirtImageController::class, 'getfile'])->name('photo');

Route::middleware('auth')->group(function () {
    Route::resource('orders', OrderController::class);

    Route::middleware('verified')->group(function () {
        // Perfil
        Route::get('/profile/{user}', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{user}/update', [UserController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{user}/deletephoto', [UserController::class, 'deletePhoto'])
            ->name('profile.deletephoto');
        Route::get('/tshirtImage/{tshirtImage}', [TshirtImageController::class, 'getImage'])
            ->name('getImage');
    });

    Route::middleware('customer')->group(function () {
        Route::get('/profile/{user}/my-tshirts', [TshirtImageController::class, 'myTshirts'])->name('profile.mytshirts');
        Route::get('profile/{user}/{slug}/edit', [TshirtImageController::class, 'editMyTshirt'])->name('tshirt.edit');
        Route::put('/profile/{user}/{slug}/update', [TshirtImageController::class, 'updateMyTshirt'])->name('tshirt.update');
        Route::get('/profile/{user}/createTshirt', [TshirtImageController::class, 'createMyTshirt'])->name('tshirt.create');
        Route::post('/profile/{user}/createTshirt', [TshirtImageController::class, 'storeMyTshirt'])->name('tshirt.store');
        Route::delete('profile/{user}/{slug}/delete', [TshirtImageController::class, 'destroyMyTshirt'])->name('tshirt.destroy');


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
        Route::get('/dashboard/{user}/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
        Route::get('/dashboard/employees/add', [DashboardController::class, 'addEmployee'])->name('dashboard.addEmployee');
        Route::post('/dashboard/employees/store', [DashboardController::class, 'storeEmployee'])->name('dashboard.storeEmployee');
        Route::get('/dashboard/admins/add', [DashboardController::class, 'addAdmin'])->name('dashboard.addAdmin');
        Route::post('/dashboard/admins/store', [DashboardController::class, 'storeAdmin'])->name('dashboard.storeAdmin');
        Route::delete('/dashboard/{user}/deletephoto', [DashboardController::class, 'deletePhoto'])->name('dashboard.deletephoto');
        Route::put('/dashboard/{user}/updateData', [DashboardController::class, 'updateData'])->name('dashboard.updateData');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData']);
        Route::get('/dashboard/pie-chart-data', [DashboardController::class, 'pieChartData']);

        Route::delete('/dashboard/user/delete/{user}', [DashboardController::class, 'deleteUser'])->name('dashboard.user.delete');
        Route::put('/dashboard/user/block/{user}', [DashboardController::class, 'changeUserStatus'])->name('dashboard.user.block');

        // change prices
        Route::get('/dashboard/prices', [PriceController::class, 'showPrices'])->name('dashboard.showPrices');
        Route::post('/dashboard/prices/update', [PriceController::class, 'updatePrices'])->name('dashboard.updatePrices');

        //change color
        Route::get('/dashboard/colors', [ColorController::class, 'index'])->name('dashboard.showColors');
        Route::delete('/dashboard/colors/delete/{color}', [ColorController::class, 'delete'])->name('dashboard.deleteColor');
        Route::get('/dashboard/colors/edit/{color}', [ColorController::class, 'edit'])->name('dashboard.editColor');
        Route::put('/dashboard/colors/update/{color}', [ColorController::class, 'update'])->name('dashboard.updateColor');
        Route::get('/dashboard/colors/add', [ColorController::class, 'create'])->name('dashboard.addColor');
        Route::post('/dashboard/colors/store', [ColorController::class, 'store'])->name('dashboard.storeColor');

        //change categories
        Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('dashboard.showCategories');
        Route::delete('/dashboard/categories/delete/{category}', [CategoryController::class, 'delete'])->name('dashboard.deleteCategory');
        Route::get('/dashboard/categories/edit/{category}', [CategoryController::class, 'edit'])->name('dashboard.editCategory');
        Route::put('/dashboard/categories/update/{category}', [CategoryController::class, 'update'])->name('dashboard.updateCategory');
        Route::get('/dashboard/categories/add', [CategoryController::class, 'create'])->name('dashboard.addCategory');
        Route::post('/dashboard/categories/store', [CategoryController::class, 'store'])->name('dashboard.storeCategory');

        // catalog
        Route::get('catalog/{slug}/edit', [TshirtImageController::class, 'edit'])->name('catalog.edit');
        Route::delete('catalog/{catalog}/delete', [TshirtImageController::class, 'destroy'])->name('catalog.destroy');
        Route::get('catalog/create', [TshirtImageController::class, 'create'])->name('catalog.tshirt.create');
        Route::post('catalog/store', [TshirtImageController::class, 'store'])->name('catalog.tshirt.store');


    });

    Route::middleware('employee')->group(function () {
        Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('dashboard.orders');
        Route::put('/dashboard/orders/{order}/update', [OrderController::class, 'update'])->name('dashboard.orders.update');
        Route::get('/dashboard/orders/{order}/details', [OrderController::class, 'showDetails'])->name('dashboard.orders.details');
    });

    Route::get('/password/change', [ChangePasswordController::class, 'show'])
        ->name('password.change.show');
    Route::post('/password/change', [ChangePasswordController::class, 'store'])
        ->name('password.change.store');
});


// Carrinho
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::delete('/cart/{productId}/delete', [CartController::class, 'removeFromCart'])->name('cart.remove');

// pdf invoice
Route::get('/receipt/{orderId}', [OrderController::class, 'viewReceipt'])->name('receipt.view');
Route::get('/receipt/{orderId}/download', [OrderController::class, 'downloadReceipt'])->name('receipt.download');