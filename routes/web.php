<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/category/{slug}',[CategoryController::class,'detail']);

// Route::get('/category/electronics/{slug}',[SubcategoryController::class,'detail']);

// Route::get('/category/electronics/tv/{slug}',[ProductdetailController::class,'detail']);
Route::get('/category/{categorySlug}/{subcategorySlug}/{slug}',[ProductdetailController::class,'detail']);
Route::get('/product/{slug}',[ProductdetailController::class,'detail']);

Route::get('/category/{categorySlug}/{subcategorySlug}', [SubcategoryController::class, 'detail']);

Route::get('/cart-list',[CartController::class,'list'])->name('cart-list');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

Route::get('/checkout/{slug}',[CheckoutController::class,'checkout'])->name('checkout');;

Route::get('register',[UserController::class,'register']);

Route::get('register1',[UserController::class,'register1']);

Route::get('login',[UserController::class,'login'])->name('login');

Route::get('login1',[UserController::class,'login1']);
Route::get('logout',[UserController::class,'logout']);

// User Dashboard Routes Start Here:
Route::get('user/',[UserController::class,'index']);

Route::get('user/order-history/',[UserController::class,'history']);

Route::get('user/detail/',[UserController::class,'detail']);

Route::get('user/settings/',[UserController::class,'settings']);


// Vendor Dashboard Route Srart Here:

Route::get('vendor/signup',[VendorController::class,'signup']);

Route::get('vendor/login',[VendorController::class,'login']);

Route::get('vendor/forget',[VendorController::class,'forget']);

Route::get('vendor/',[VendorController::class,'index'])->name('vendor.index');

Route::get('vendor/add-product',[VendorController::class,'addproduct']);

Route::get('vendor/view-product',[VendorController::class,'viewproduct']);

// Route::get('vendor/edit-product',[VendorController::class,'editproduct']);
Route::get('vendor/edit-product/{id}/edit',[VendorController::class,'editproduct'])->name('vendor.edit-product');

Route::get('vendor/orders',[VendorController::class,'orders']);

Route::get('vendor/order-detail',[VendorController::class,'orderdetail']);

Route::get('vendor/users',[VendorController::class,'users']);

Route::get('vendor/profile',[VendorController::class,'profile']);

// Vendor Category Routes (Add GET & POST)
Route::get('vendor/add-category', [VendorController::class, 'addcategory']);
Route::post('vendor/add-category', [VendorController::class, 'storeCategory'])->name('vendor.category.store');
Route::get('vendor/view-category', [VendorController::class, 'viewCategory']);


// Admin Dashboard Start Here

Route::get('admin/login',[AdminController::class,'login']);

Route::get('admin/',[AdminController::class,'index']);

Route::get('admin/order-detail',[AdminController::class,'orderdetail']);

Route::get('admin/add-category',[AdminController::class,'addcategory']);

Route::get('admin/view-category',[AdminController::class,'viewcategory']);

Route::get('admin/edit-category',[AdminController::class,'editcategory']);

Route::get('admin/users',[AdminController::class,'users']);

Route::get('admin/vendors',[AdminController::class,'vendors']);

Route::get('admin/orders',[AdminController::class,'orders']);


// Route::get('admin/products',[AdminController::class,'products']);


Route::post('/products/store', [ProductdetailController::class, 'store'])->name('products.store');
Route::post('products/edit-product/{id}', [ProductdetailController::class, 'updateProduct'])->name('products.update');
Route::delete('products/delete-product/{id}', [ProductdetailController::class, 'deleteProduct'])->name('products.delete-product');
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');

// Route::get('checkout/product', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity']);

