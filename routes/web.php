<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\Auth\StaffLoginController;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Frontend pages
Route::get('/features', function () {
    return view('frontend.features');
})->name('features');

Route::get('/how-it-works', function () {
    return view('frontend.how-it-works');
})->name('how-it-works');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Auth::routes();

// Staff login (with 6-digit code)
Route::get('/staff-login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login.form');
Route::post('/staff-login', [StaffLoginController::class, 'login'])->name('staff.login');

// Customer public routes (QR ordering)
Route::get('/r/{slug}', [CustomerController::class, 'restaurant'])->name('customer.restaurant');
Route::get('/table/{qrCode}', [CustomerController::class, 'table'])->name('customer.table');
Route::post('/customer/order', [CustomerController::class, 'placeOrder'])->name('customer.order.place');
Route::get('/order/{orderNumber}', [CustomerController::class, 'track'])->name('customer.track');
Route::get('/order/{orderNumber}/status', [CustomerController::class, 'status'])->name('customer.order.status');

// Onboarding (after registration, before dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
});

// Dashboard routes (auth + restaurant setup required)
// Role permission map (spec section 7 / 27.8):
//   owner        -> full access to everything below (always allowed, see EnsureRole)
//   manager      -> daily operations: menu, tables, staff, reports, orders, kitchen, waiter, reception
//   reception    -> orders, reception desk (accept/reject/payments)
//   waiter       -> orders (create/serve), waiter desk
//   chef         -> kitchen only (no financials, no staff/settings)
Route::middleware(['auth', 'restaurant.setup'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Menu, Tables, Staff, Reports - owner & manager only
    Route::middleware('role:manager')->group(function () {
        Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/menu/categories', [MenuController::class, 'storeCategory'])->name('menu.categories.store');
        Route::post('/menu/items', [MenuController::class, 'storeItem'])->name('menu.items.store');
        Route::patch('/menu/items/{item}/toggle', [MenuController::class, 'toggleItem'])->name('menu.items.toggle');
        Route::delete('/menu/items/{item}', [MenuController::class, 'destroyItem'])->name('menu.items.destroy');
        Route::delete('/menu/categories/{category}', [MenuController::class, 'destroyCategory'])->name('menu.categories.destroy');

        Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
        Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
        Route::patch('/tables/{table}/status', [TableController::class, 'updateStatus'])->name('tables.status');
        Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');

        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::delete('/staff/{user}', [StaffController::class, 'destroy'])->name('staff.destroy');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

    // Settings - owner only (sensitive business/financial config)
    Route::middleware('role:owner')->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // Order Management - owner, manager, reception, waiter (not chef - kitchen board covers them)
    Route::middleware('role:manager,reception,waiter')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    });

    // Kitchen (Chef)
    Route::middleware('role:manager,chef')->group(function () {
        Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
        Route::patch('/kitchen/orders/{order}/status', [KitchenController::class, 'updateStatus'])->name('kitchen.status');
    });

    // Waiter
    Route::middleware('role:manager,waiter')->group(function () {
        Route::get('/waiter', [WaiterController::class, 'index'])->name('waiter.index');
        Route::patch('/waiter/orders/{order}/serve', [WaiterController::class, 'serve'])->name('waiter.serve');
        Route::post('/waiter/orders/{order}/collect', [WaiterController::class, 'collectCash'])->name('waiter.collect');
    });

    // Reception
    Route::middleware('role:manager,reception')->group(function () {
        Route::get('/reception', [ReceptionController::class, 'index'])->name('reception.index');
        Route::patch('/reception/orders/{order}/accept', [ReceptionController::class, 'acceptOrder'])->name('reception.accept');
        Route::patch('/reception/orders/{order}/reject', [ReceptionController::class, 'rejectOrder'])->name('reception.reject');
        Route::patch('/reception/payments/{payment}/confirm', [ReceptionController::class, 'confirmPayment'])->name('reception.payment.confirm');
        Route::post('/reception/orders/{order}/payment', [ReceptionController::class, 'recordPayment'])->name('reception.payment.record');
        Route::get('/reception/orders/{order}/receipt', [ReceptionController::class, 'receipt'])->name('reception.receipt');
    });
});
