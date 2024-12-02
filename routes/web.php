<?php

use app\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\whyController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

    // HomeController routes
    Route::get('/dashboard', [HomeController::class, 'home_login'])->name('dashboard');
    Route::get('/myOrders', [HomeController::class, 'myOrders'])->name('myOrders');
    Route::post('/product/{id}/comments', [CommentsController::class, 'store'])->name('comments.store');


    // CartController routes
    Route::get('/myCart', [CartController::class, 'index'])->name('myCart');
    Route::post('/cart/add/{id}', [CartController::class, 'add_cart'])->name('add_cart');
    Route::delete('/myCart/{id}', [CartController::class, 'delete'])->name('myCart_delete');

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

Route::post('/Contact-us/storeMsg',[contactController::class,'storeMsg'])->name('contact.storeMsg');



//profile routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//admin routes

Route::middleware(['auth', 'verified','admin'])->prefix("/admin")->group(function () {

    // admin dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // admin categories
    Route::get('/category', [AdminController::class, 'category'])->name('admin.category');
    Route::post('/add_category', [AdminController::class, 'add_category'])->name('admin.add_category');
    Route::get('/category/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit_category');
    Route::put('/category/{id}', [AdminController::class, 'update'])->name('admin.update_category');
    Route::delete('/category/{id}', [AdminController::class, 'destroyCategory'])->name('admin.destroy_category');


    // stores
    Route::get('/Stores', [StoreController::class, 'index'])->name('admin.stores');
    Route::get('/addStore', [StoreController::class, 'addStore'])->name('admin.addStore');
    Route::post('/pushStore', [StoreController::class, 'pushStore'])->name('admin.pushStore');
    Route::get('/Stores/{id}/edit', [StoreController::class, 'editStore'])->name('admin.editStore');
    Route::put('/Stores/{id}', [StoreController::class, 'updateStore'])->name('admin.updateStore');
    Route::delete('/Stores/{id}', [StoreController::class, 'storeDestroy'])->name('admin.destroyStore');





    // Products
    Route::get('/addProduct', [AdminController::class, 'addProduct'])->name('admin.add_product');
    Route::post('/addProduct', [AdminController::class, 'storeProduct'])->name('admin.store_product');
    Route::get('/Products', [AdminController::class, 'viewProducts'])->name('admin.view_products');
    Route::get('/Product/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.edit_product');
    Route::put('/product/{id}', [AdminController::class, 'updateProduct'])->name('admin.update_product');
    Route::delete('/Products/{id}', [AdminController::class, 'productDestroy'])->name('admin.destroy_product');
    Route::post('/Product/results', [AdminController::class, 'productSearch'])->name('admin.search_product');

    //Roles
    Route::get('/Roles', [AdminController::class, 'role'])->name('admin.role');
    Route::post('/Roles/admin/{id}', [AdminController::class, 'adminRole'])->name('admin.adminRole');
    Route::post('/Roles/user/{id}', [AdminController::class, 'userRole'])->name('admin.userRole');

    //Orders
    Route::get('/Orders', [AdminController::class, 'viewOrders'])->name('admin.orders');
    Route::post('/Orders/onTheWay/{id}', [AdminController::class, 'onTheWay'])->name('admin.order_onTheWay');
    Route::post('/Orders/Delivered/{id}', [AdminController::class, 'Delivered'])->name('admin.order_Delivered');
});



