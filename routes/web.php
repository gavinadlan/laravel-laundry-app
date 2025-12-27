<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

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

// Authentication routes (public) - guest middleware prevents logged in users from accessing
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Redirect root to login if not authenticated, otherwise to orders
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('orders.index');
    }
    return redirect()->route('login');
});

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Resourceful routes for CRUD operations
    Route::resource('customers', CustomerController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class);

    // Reports
    Route::get('reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
});