<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(); // we should be Auth befor to go to any Route

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Product Route

Route::get('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');

Route::post('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart');

Route::get('products/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart');

Route::get('products/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');

//checkout
Route::post('products/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');

Route::get('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout');

Route::post('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'procceedCheckout'])->name('procceed.checkout');

Route::post('products/checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('procceed.checkout');

//booking
Route::post('products/booking', [App\Http\Controllers\Products\ProductsController::class, 'BookTables'])->name('booking.table');

//Menu
Route::get('products/menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');
