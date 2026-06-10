<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
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
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard (Semua User Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

});

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('/users', UserController::class);

    Route::get('/backup', [BackupController::class,'index']);
    Route::post('/backup/download',[BackupController::class,'download']);

});

/*
|--------------------------------------------------------------------------
| Admin + Gudang
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,gudang'])->group(function () {
    Route::get('/products/{product}/qr',[ProductController::class, 'qr']);
    Route::get('/scan-qr', function () {return view('products.scan_qr');});
    
    Route::resource('/products', ProductController::class);

    Route::resource('/categories', CategoryController::class);

    Route::resource('/suppliers', SupplierController::class);

    Route::resource('/warehouses', WarehouseController::class);

    Route::resource('/stock-in', StockInController::class);

    Route::resource('/stock-out', StockOutController::class);

    Route::resource('/stock-opname', StockOpnameController::class);

    Route::get('/stock-card', [StockCardController::class, 'index']);

    Route::get('/products-import', [ProductController::class, 'importForm']);
    Route::post('/products-import', [ProductController::class, 'import']);

});

/*
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::get('/stock-report', [StockReportController::class, 'index']);
    Route::get('/stock-report/pdf', [StockReportController::class, 'pdf']);
    Route::get('/stock-report/export', [StockReportController::class, 'export']);

    Route::get('/activity-logs', [ActivityLogController::class, 'index']);

    Route::resource('/purchase-orders', PurchaseOrderController::class);

    Route::post('/purchase-orders/{purchaseOrder}/approve',[PurchaseOrderController::class, 'approve']);

    Route::post('/purchase-orders/{purchaseOrder}/cancel',[PurchaseOrderController::class, 'cancel']);

    Route::get('/stock-report/print', [StockReportController::class, 'print']);

    Route::post('/purchase-orders/{purchaseOrder}/receive',[PurchaseOrderController::class, 'receive']
);
});

/*
|--------------------------------------------------------------------------
| Admin + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,sales'])->group(function () {

    Route::resource('/item-requests', ItemRequestController::class);

    Route::post(
        '/item-requests/{itemRequest}/approve',
        [ItemRequestController::class, 'approve']
    );

    Route::post(
        '/item-requests/{itemRequest}/reject',
        [ItemRequestController::class, 'reject']
    );

});