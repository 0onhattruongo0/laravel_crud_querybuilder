<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostController;

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

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('sanpham',[HomeController::class, 'getForm'])->name('product');
Route::post('sanpham',[HomeController::class, 'addProduct'])->name('add_product');

Route::prefix('users')->name('users.')->group(function(){
    Route::get('/',[UsersController::class, 'index'])->name('index');
    Route::get('/add',[UsersController::class, 'add'])->name('add');
    Route::post('/add',[UsersController::class, 'postAdd']);
    Route::get('/edit/{id}',[UsersController::class, 'edit'])->name('edit');
    Route::post('/edit',[UsersController::class, 'postEdit'])->name('postEdit');
    Route::get('/delete/{id}',[UsersController::class, 'delete'])->name('delete');
    }
);

Route::prefix('posts')->name('posts.')->group(function(){
    Route::get('/',[PostController::class,'index']);
});

