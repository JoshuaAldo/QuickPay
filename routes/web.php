<?php

use App\Exports\OrdersExport;
use App\Exports\ProductsCategoryExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Exports\PurchaseExport;
use App\Http\Controllers\DraftOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PurchaseOfGoodsController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SearchController;

Route::middleware('guest')->group(function () {

    Route::get('/registration', [AuthController::class, 'showRegistration'])->name('registration.show');
    Route::post('/registration/submit', [AuthController::class, 'submitRegistration'])->name('registration.submit');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/product');
    });

    Route::resource('product', productController::class);
    Route::get('search', [SearchController::class, 'search'])->name('search');


    Route::resource('product_category', categoryController::class);

    Route::resource('order', OrderController::class);


    Route::post('/print-receipt', [PrintController::class, 'printReceipt'])->name('print.receipt');
    Route::get('/receipt-preview/{id}', [PrintController::class, 'receiptPreview'])->name('receipt.preview');

    Route::resource('draftOrder', DraftOrderController::class);

    Route::post('order/redirect/{draftId}', [OrderController::class, 'redirectToOrderPage'])->name('order.redirectToOrder');


    Route::resource('sales-report', SalesReportController::class);
    Route::get('sales-report/filter', [SalesReportController::class, 'index'])->name('sales-report.filter');

    Route::resource('purchase-of-goods', PurchaseOfGoodsController::class);
    Route::get('purchase-of-goods/filter', [PurchaseOfGoodsController::class, 'index'])->name('purchase-of-goods.filter');

    Route::get('export-products', function () {
        return Excel::download(new ProductsExport, 'products.xlsx');
    })->name('export.products');

    Route::get('export-products-category', function () {
        return Excel::download(new ProductsCategoryExport, 'productsCategory.xlsx');
    })->name('export.productsCategory');

    Route::get('export-orders', function () {
        return Excel::download(new OrdersExport, 'Sales-Reports.xlsx');
    })->name('export.orders');

    Route::get('export-purchase', function () {
        return Excel::download(new PurchaseExport, 'Purchase-of-Goods-Reports.xlsx');
    })->name('export.purchase');

    // Route::get('/order', function () {
    //     return view('order');
    // });
});
