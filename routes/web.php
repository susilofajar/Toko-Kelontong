<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root to dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard - accessible by all roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile - accessible by all roles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |----------------------------------------------------------------------
    | Admin Routes
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        // Products
        Route::resource('products', ProductController::class)->except(['show']);

        // Categories
        Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);

        // Suppliers
        Route::resource('suppliers', SupplierController::class)->except(['show', 'create', 'edit']);

        // Customers
        Route::resource('customers', CustomerController::class)->except(['show', 'create', 'edit']);

        // Users
        Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Inventory
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/stock-in', [InventoryController::class, 'stockIn'])->name('inventory.stock-in');
        Route::post('/inventory/stock-in', [InventoryController::class, 'processStockIn'])->name('inventory.process-stock-in');
        Route::get('/inventory/stock-out', [InventoryController::class, 'stockOut'])->name('inventory.stock-out');
        Route::post('/inventory/stock-out', [InventoryController::class, 'processStockOut'])->name('inventory.process-stock-out');
        Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');
    });

    /*
    |----------------------------------------------------------------------
    | Admin + Cashier Routes
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin,cashier'])->group(function () {
        // POS
        Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
        Route::get('/pos/search', [\App\Http\Controllers\PosController::class, 'searchProduct'])->name('pos.search');
        Route::post('/pos/checkout', [\App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/receipt/{sale}', [\App\Http\Controllers\PosController::class, 'receipt'])->name('pos.receipt');

        // Sales History
        Route::get('/sales', [\App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
        Route::get('/sales/{sale}', [\App\Http\Controllers\SaleController::class, 'show'])->name('sales.show');

        // Debts (Kasbon)
        Route::get('/debts', [\App\Http\Controllers\DebtController::class, 'index'])->name('debts.index');
        Route::post('/debts/{sale}/pay', [\App\Http\Controllers\DebtController::class, 'pay'])->name('debts.pay');
    });

    /*
    |----------------------------------------------------------------------
    | Admin + Owner Routes (Reports)
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin,owner'])->group(function () {
        Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
        Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/reports/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
        Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('/reports/best-selling', [ReportController::class, 'bestSelling'])->name('reports.best-selling');
        Route::get('/reports/daily/export-pdf', [ReportController::class, 'exportDailyPdf'])->name('reports.daily.pdf');
        Route::get('/reports/monthly/export-pdf', [ReportController::class, 'exportMonthlyPdf'])->name('reports.monthly.pdf');
    });
});
