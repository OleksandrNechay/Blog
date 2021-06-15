<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\Admin\CategoryController;
use App\Http\Controllers\Blog\Admin\PostsController;
use App\Http\Controllers\Blog\Admin\DashboardController;
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
Route::get('layout', [DashboardController::class, 'dashboard'])->name('layout');


//Адмінка
$groupData = ['prefix' => 'admin/blog'];

//Category
Route::group($groupData, function() {
    $methods = ['index', 'edit' , 'create','store', 'update'];
    Route::resource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');

//Posts
    Route::resource('posts', PostsController::class)
        ->except(['show'])
        ->names('blog.admin.posts');

});
