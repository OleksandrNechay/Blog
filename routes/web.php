<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\Admin\DashboardController;
use App\Http\Controllers\Blog\Admin\PostsController;
use App\Http\Controllers\Blog\Admin\CategoryController;
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

require __DIR__.'/auth.php';

Route::get('dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('main', [PostsController::class, 'mainPage'])->name('main');
Route::get('show/{id}',[PostsController::class, 'show'])->name('show');

//Адмінка
$groupData = ['prefix' => 'admin/blog'];

//Category
Route::group($groupData, function() {
    $methods = ['index', 'edit' , 'create','store', 'update', ];
    Route::resource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');
    Route::get('show/categorypost', [DashboardController::class, 'categoryPosts'])->name('categories');
    Route::get('show/categoryposts/{id}', [DashboardController::class, 'getPosts'])->name('categoryPosts');

//Posts
    Route::resource('posts', PostsController::class)
        ->except(['show'])
        ->names('blog.admin.posts');
    Route::get('posts/published', [DashboardController::class, 'published'])->name('published');
    Route::get('posts/deleted', [DashboardController::class, 'deleted'])->name('deleted');
    Route::get('posts/not_published', [DashboardController::class, 'notPublished'])->name('not_published');
});
