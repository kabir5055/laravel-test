<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return redirect()->to('/login');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::post('/dropzone', 'App\Http\Controllers\HomeController@index')->name('file-upload');

Route::middleware('auth')->group(function () {
    Route::resource('product-variant', 'App\Http\Controllers\VariantController');
    Route::resource('product', 'App\Http\Controllers\ProductController');
    Route::post('/save-product',[ProductController::class,'saveProduct'])->name('save.product');
    Route::get('/manage-product',[ProductController::class,'manageProduct'])->name('manage.product');
    Route::get('/filter-product',[ProductController::class,'filterProduct'])->name('filter.product');
    Route::get('/edit-product/{id}',[ProductController::class,'editProduct'])->name('edit.product');
    Route::post('/update-product',[ProductController::class,'updateProduct'])->name('update.product');
    Route::resource('blog', 'App\Http\Controllers\BlogController');
    Route::resource('blog-category', 'App\Http\Controllers\BlogCategoryController');
});
