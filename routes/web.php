<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseOrderController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('user', UserController::class)->middleware('auth');
Route::resource('purchase', PurchaseOrderController::class)->middleware('auth');

Route::get('/ajax-user',[UserController::class, 'ajax']);
Route::get('/ajax-purchase',[PurchaseOrderController::class, 'ajax']);

Route::get('/customers/{id}',[PurchaseOrderController::class, 'list_detail_customer']);
Route::get('/customer-orders/{id}',[PurchaseOrderController::class, 'list_detail_customer_order']);

