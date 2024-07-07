<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\whyController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [HomeController::class, 'home_login'])->middleware(['auth','verified'])->name('dashboard');

Route::get('/cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth','verified'])->name('add_cart');

Route::get('/myCart', [CartController::class, 'index'])->middleware(['auth','verified'])->name('myCart');

Route::get('/myOrders', [HomeController::class, 'myOrders'])->middleware(['auth','verified'])->name('myOrders');

Route::get('/myCart/{id}', [CartController::class, 'delete'])->middleware(['auth','verified'])->name('myCart_delete');

Route::post('/myCart/placeOrder', [CartController::class, 'placeOrder'])->middleware(['auth','verified'])->name('placeOrder');

Route::post('/myCart/payWithPaypal', [CartController::class, 'payWithPaypal'])->middleware(['auth','verified'])->name('payWithPaypal');

Route::get('/myCart/payWithPaypal/{id}', [PaymentController::class, 'payment'])->middleware(['auth','verified'])->name('payment');
Route::get('/Paypal/success}', [PaymentController::class, 'success'])->middleware(['auth','verified']);
Route::get('/cancel', [PaymentController::class, 'cancel'])->middleware(['auth','verified']);

Route::get('product/{id}',[homeController::class,'product_details'])->name('product_details');

Route::get('/Shop', [ShopController::class, 'index'])->name('shop');

Route::get('/Test',[TestController::class,'index'])->name('test');

Route::get('/why',[whyController::class,'index'])->name('why');

Route::get('/Contact-us',[contactController::class,'index'])->name('contact');

Route::get('/create-transaction', [PaymentController::class, 'createTransaction'])->name('createTransaction');
Route::get('/success-transaction', [PaymentController::class, 'successTransaction'])->name('successTransaction');
Route::get('/cancel-transaction', [PaymentController::class, 'cancelTransaction'])->name('cancelTransaction');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('admin/category', [AdminController::class, 'category'])->middleware(['auth','admin'])->name('admin.category');


Route::get('admin/dashboard', [AdminController::class, 'index'])->middleware(['auth','admin'])->name('admin.dashboard');

Route::post('admin/add_category', [AdminController::class, 'add_category'])
     ->middleware(['auth','admin'])->name('admin.add_category');

 Route::delete('admin/category/{id}', [AdminController::class, 'destroy'])
     ->middleware(['auth','admin'])->name('admin.destroy_category');

Route::get('admin/category/{id}/edit', [AdminController::class, 'edit'])
    ->middleware(['auth','admin'])->name('admin.edit_category');

Route::put('admin/category/{id}', [AdminController::class, 'update'])
    ->middleware(['auth','admin'])->name('admin.update_category');

Route::get('admin/addProduct', [AdminController::class, 'addProduct'])
    ->middleware(['auth','admin'])->name('admin.add_product');

Route::post('admin/addProduct', [AdminController::class, 'storeProduct'])
    ->middleware(['auth','admin'])->name('admin.store_product');

Route::get('admin/Products', [AdminController::class, 'viewProducts'])
    ->middleware(['auth','admin'])->name('admin.view_products');

Route::delete('admin/Products/{id}', [AdminController::class, 'productDestroy'])
    ->middleware(['auth','admin'])->name('admin.destroy_product');

Route::post('admin/Product/results', [AdminController::class, 'productSearch'])
    ->middleware(['auth','admin'])->name('admin.search_product');

Route::get('admin/Product/{id}/edit', [AdminController::class, 'editProduct'])
    ->middleware(['auth','admin'])->name('admin.edit_product');

Route::put('admin/product/{id}', [AdminController::class, 'updateProduct'])
    ->middleware(['auth','admin'])->name('admin.update_product');

Route::get('admin/Orders', [AdminController::class, 'viewOrders'])
    ->middleware(['auth','admin'])->name('admin.orders');

Route::post('admin/Orders/onTheWay/{id}', [AdminController::class, 'onTheWay'])
    ->middleware(['auth','admin'])->name('admin.order_onTheWay');

Route::post('admin/Orders/Delivered/{id}', [AdminController::class, 'Delivered'])
    ->middleware(['auth','admin'])->name('admin.order_Delivered');
