<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

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
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/image_submit',[PostsController::class,'submitImage'])->name('submit_image');
    Route::get('/test', [PostsController::class, 'test'])->name('test');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/create', [PostsController::class, 'create'])->name('create');
    Route::get('/read', [PostsController::class, 'index'])->name('read');
    Route::get('/post', [PostsController::class, 'show'])->name('post');
    Route::post('/add', [PostsController::class, 'store'])->name('add');
    Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('edit');
    Route::post('/posts/{post}', [PostsController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PostsController::class, 'destroy'])->name('delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
