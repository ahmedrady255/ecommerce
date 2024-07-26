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
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ordersController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // HomeController routes
    Route::get('/dashboard', [HomeController::class, 'home_login'])->name('dashboard');
    Route::get('/myOrders', [HomeController::class, 'myOrders'])->name('myOrders');
    Route::post('/product/{id}/comments', [CommentsController::class, 'store'])->name('comments.store');


    // CartController routes
    Route::get('/myCart', [CartController::class, 'index'])->name('myCart');
    Route::post('/cart/add/{id}', [CartController::class, 'add_cart'])->name('add_cart');
    Route::get('/myCart/{id}', [CartController::class, 'delete'])->name('myCart_delete');

    //ordersController routs
    Route::post('/myCart/placeOrder', [ordersController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/myCart/payWithPaypal', [ordersController::class, 'payWithPaypal'])->name('payWithPaypal');

    // PaymentController routes
    Route::get('/myCart/payWithPaypal/{id}', [PaymentController::class, 'payment'])->name('payment');
    Route::get('/Paypal/success', [PaymentController::class, 'success']);
    Route::get('/cancel', [PaymentController::class, 'cancel']);
});
Route::get('product/{id}',[homeController::class,'product_details'])->name('product_details');

Route::get('/Shop', [ShopController::class, 'index'])->name('shop');

Route::get('/Test',[TestController::class,'index'])->name('test');

Route::get('/why',[whyController::class,'index'])->name('why');

Route::get('/Contact-us',[contactController::class,'index'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('admin/category', [AdminController::class, 'category'])
    ->middleware(['auth','admin'])->name('admin.category');


Route::get('admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth','admin'])->name('admin.dashboard');

Route::post('admin/add_category', [AdminController::class, 'add_category'])
     ->middleware(['auth','admin'])->name('admin.add_category');

 Route::delete('admin/category/{id}', [AdminController::class, 'destroyCategory'])
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

Route::get('admin/Roles', [AdminController::class, 'role'])
    ->middleware(['auth','admin'])->name('admin.role');

Route::post('admin/Roles/admin/{id}', [AdminController::class, 'adminRole'])
    ->middleware(['auth','admin'])->name('admin.adminRole');

Route::post('admin/Roles/user/{id}', [AdminController::class, 'userRole'])
    ->middleware(['auth','admin'])->name('admin.userRole');

Route::post('admin/Orders/onTheWay/{id}', [AdminController::class, 'onTheWay'])
    ->middleware(['auth','admin'])->name('admin.order_onTheWay');

Route::post('admin/Orders/Delivered/{id}', [AdminController::class, 'Delivered'])
    ->middleware(['auth','admin'])->name('admin.order_Delivered');
