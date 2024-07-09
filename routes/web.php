<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\sub_CategoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontEnd\FrontController;
use App\Http\Controllers\FrontEnd\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class, 'index'])->name('front.homepage');    
Route::post('/shop-filter/',[ShopController::class, 'priceFilter'])->name('front.homepage.filter');
   //apply sorting filters
Route::post('/shop-sort/',[ShopController::class, 'sortFilter'])->name('front.homepage.sort');
//product page
Route::get('/product/{slug}',[ShopController::class, 'product'])->name('front.product');

//add to cart
Route::post('/add-to-cart',[ShopController::class, 'addToCart'])->name('front.cart.add');  




Route::middleware('auth')->group(function () {
    Route::controller(productController::class)->group(function () { 
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products', 'store')->name('products.store');
        Route::get('/products/{id}', 'show')->name('products.show');
        Route::get('/products/{id}/edit','edit')->name('products.edit');
        Route::put('/products', 'update')->name('products.update');
        Route::delete('/products/{id}', 'destroy')->name('products.destroy'); 
        Route::get('/get_products', 'getProducts')->name('get_ajax_products');
     }); 
     Route::controller(DashboardController::class)->group(function () {
       Route::get('/dashboard','index')->name('dashboard.index')->middleware('auth');
     //change password
     Route::get('/change-password', 'changePassword')->name('change-password');
     Route::post('/change-password', 'updatePassword')->name('change-password.post');


    }); 

    //Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories.index');
        Route::get('/categories/create', 'create')->name('categories.create');
        Route::post('/categories', 'store')->name('categories.store');
        Route::get('/categories/{id}', 'show')->name('categories.show');
        Route::get('/categories/{id}/edit','edit')->name('categories.edit');
        Route::put('/categories/{id}', 'update')->name('categories.update');
        Route::delete('/categories/{id}', 'destroy')->name('categories.destroy');

        //get slug
        Route::get('/getSlug', 'getSlug')->name('getSlug');

         
    });

    //subcategory Routes
        Route::controller(sub_CategoryController::class)->group(function () {
        Route::get('/subcategories', 'index')->name('subcategories.index');
        Route::get('/subcategories/create', 'create')->name('subcategories.create');
        Route::post('/subcategories', 'store')->name('subcategories.store');
        Route::get('/subcategories/{id}', 'show')->name('subcategories.show');
        Route::get('/subcategories/{id}/edit','edit')->name('subcategories.edit');
        Route::put('/subcategories/{id}', 'update')->name('subcategories.update');
        Route::delete('/subcategories/{id}', 'destroy')->name('subcategories.destroy');
        Route::get('/get_ajax_subcategory', 'get_ajax_subcategory')->name('get_ajax_subcategory');

        //get sub category slug
        Route::get('/subcategories/getSlug', 'getSlug')->name('subcategories.getSlug');
        



    });

    Route::controller(BrandsController::class)->group(function () {
        Route::get('/brands', 'index')->name('brands.index');
        Route::get('/brands/create', 'create')->name('brands.create');
        Route::post('/brands', 'store')->name('brands.store');
        Route::get('/brands/{id}', 'show')->name('brands.show');
        Route::get('/brands/{id}/edit','edit')->name('brands.edit');
        Route::put('/brands/{id}', 'update')->name('brands.update');
        Route::delete('/brands/{id}', 'destroy')->name('brands.destroy');
    });

});

//public
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/change-password', 'changePassword')->name('change-password');
    Route::post('/change-password', 'updatePassword')->name('change-password.post');
    
});

//forntend routes from here

Route::get('/route-cache', function() {
    Cache::flush();
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Route::clearResolvedInstances();
    return 'Routes cache cleared';
});