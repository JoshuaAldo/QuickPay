<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/registration', [AuthController::class, 'showRegistration'])->name('registration.show');
Route::post('/registration/submit', [AuthController::class, 'submitRegistration'])->name('registration.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('product', productController::class);

    Route::resource('product_category', categoryController::class);

    Route::get('/order', function () {
        return view('order');
    });

    Route::get('/draft-order', function () {
        return view('draftOrder');
    });

    Route::get('/sales-report', function () {
        return view('salesReport');
    });

    Route::get('/purchase-of-goods', function () {
        return view('purchaseOfGoods');
    });
});
