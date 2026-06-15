<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\SalesStockController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Sales Stock Search
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {
    Route::get('/sales/stock-search', [SalesStockController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::resource('/users', UserController::class);

    Route::get('/stock-report', [StockReportController::class, 'index']);
    Route::get('/stock-report/pdf', [StockReportController::class, 'pdf']);
    Route::get('/stock-report/export', [StockReportController::class, 'export']);
    Route::get('/stock-report/print', [StockReportController::class, 'print']);

    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/backup', [BackupController::class, 'index']);
    Route::post('/backup/download', [BackupController::class, 'download']);
});

/*
|--------------------------------------------------------------------------
| Inventory
| Admin + Manager + Gudang
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,gudang'])->group(function () {
    Route::get('/products/{product}/qr', [ProductController::class, 'qr']);

    Route::get('/scan-qr', function () {
        return view('products.scan_qr');
    });

    Route::get('/products/template', [ProductImportController::class, 'template'])
        ->name('products.template');

    Route::get('/products/import', [ProductImportController::class, 'index'])
        ->name('products.import.index');

    Route::post('/products/import/preview', [ProductImportController::class, 'preview'])
        ->name('products.import.preview');

    Route::post('/products/import/store', [ProductImportController::class, 'store'])
        ->name('products.import.store');

    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/brands', BrandController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/warehouses', WarehouseController::class);

    Route::resource('/stock-in', StockInController::class);
    Route::resource('/stock-out', StockOutController::class);
    Route::resource('/stock-opname', StockOpnameController::class);
});

/*
|--------------------------------------------------------------------------
| Kartu Stok
| Admin + Manager + Gudang + Sales + Purchasing
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,gudang,sales,purchasing'])->group(function () {
    Route::get('/stock-card', [StockCardController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Request Barang
| Admin + Manager + Gudang
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,gudang'])->group(function () {
    Route::resource('/item-requests', ItemRequestController::class);

    Route::post('/item-requests/{itemRequest}/approve', [ItemRequestController::class, 'approve']);
    Route::post('/item-requests/{itemRequest}/reject', [ItemRequestController::class, 'reject']);
});

/*
|--------------------------------------------------------------------------
| Supplier + Purchase Order
| Admin + Manager + Purchasing
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,purchasing'])->group(function () {
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/purchase-orders', PurchaseOrderController::class);

    Route::post('/purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive']);
});

/*
|--------------------------------------------------------------------------
| Approval Purchase Order
| Admin + Manager Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::post('/purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve']);
    Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel']);
});