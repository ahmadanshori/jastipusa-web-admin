<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ExchangeController;
use App\Http\Middleware\CheckRole;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Auth::routes();

Route::resource('user', UserController::class)->middleware(['auth',CheckRole::class]);
Route::resource('payment-method', PaymentMethodController::class)->middleware(['auth',CheckRole::class]);
Route::resource('exchange', ExchangeController::class)->middleware(['auth',CheckRole::class]);

Route::put('/change-password/{id}', [UserController::class, 'changePassword'])->middleware('auth')->name('user.change-password');

Route::resource('purchase', PurchaseOrderController::class)->middleware('auth');
Route::resource('customer', CustomerController::class)->middleware(['auth',CheckRole::class]);
Route::get('/customer-export', [CustomerController::class, 'exportExcel'])->name('customer.export');
Route::get('/purchase-export', [PurchaseOrderController::class, 'export'])->name('purchase.export');

Route::get('/ajax-user',[UserController::class, 'ajax']);
Route::get('/ajax-purchase',[PurchaseOrderController::class, 'ajax']);
Route::get('/ajax-customer',[CustomerController::class, 'ajax']);
Route::get('/ajax-order-detail/{id}',[CustomerController::class, 'ajaxOrderDetail']);
Route::get('/ajax-payment-method',[PaymentMethodController::class, 'ajax']);
Route::get('/ajax-exchange',[ExchangeController::class, 'ajax']);
Route::get('/ajax-tracking',[TrackingController::class, 'ajax']);

Route::resource('tracking', TrackingController::class)->middleware('auth');


Route::get('/customers/{id}',[PurchaseOrderController::class, 'list_detail_customer']);
Route::get('/customer-orders/{id}',[PurchaseOrderController::class, 'list_detail_customer_order']);
Route::get('/customer-orders',[PurchaseOrderController::class, 'list_customer_order']);

Route::post('/purchase-order-detail/{id}/update-estimasi', [PurchaseOrderController::class, 'updateEstimasi'])
    ->name('purchase-items.update-estimasi');

    Route::post('/purchase-order-detail/{id}/update-hpp', [PurchaseOrderController::class, 'updateHpp'])
    ->name('purchase-items.update-hpp');

     Route::post('/purchase-order-detail/{id}/update-operasional', [PurchaseOrderController::class, 'updateOprasional'])
    ->name('purchase-items.update-oprasional');

Route::get('/purchase/{id}/pdf', [PurchaseOrderController::class, 'generatePDF'])
    ->name('purchase.pdf');

Route::get('/purchase-estimasi/{id}/pdf', [PurchaseOrderController::class, 'generatePDFEstimasi'])
->name('purchase-estimasi.pdf');

Route::get('/purchase-hpp/{id}/pdf', [PurchaseOrderController::class, 'generatePDFHpp'])
->name('purchase-hpp.pdf');

Route::get('/purchase-operasional/{id}/pdf', [PurchaseOrderController::class, 'generatePDFOperasional'])
->name('purchase-operasional.pdf');

Route::get('/purchase-received/{id}/pdf', [PurchaseOrderController::class, 'generatePDFReceived'])
->name('purchase-received.pdf');
