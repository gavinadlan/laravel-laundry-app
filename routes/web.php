<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceCategoryController;

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
    // Dashboard - accessible by admin and manager
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resourceful routes for CRUD operations
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/payments', [CustomerController::class, 'payments'])->name('customers.payments');
    Route::resource('service-categories', ServiceCategoryController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class);

    // Invoices
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{order}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{order}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('invoices/{order}/email', [InvoiceController::class, 'email'])->name('invoices.email');

    // Reports
    Route::get('reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('reports/per-customer', [ReportController::class, 'perCustomer'])->name('reports.per-customer');
    Route::get('reports/per-service', [ReportController::class, 'perService'])->name('reports.per-service');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/accounts-receivable', [ReportController::class, 'accountsReceivable'])->name('reports.accounts-receivable');
    Route::get('reports/export/orders', [ReportController::class, 'exportOrders'])->name('reports.export.orders');
    Route::get('reports/export/payments', [ReportController::class, 'exportPayments'])->name('reports.export.payments');
    Route::get('reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
});
