<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\Admin\DashboardController;
use App\Http\Controllers\Blog\Admin\PostsController;
use App\Http\Controllers\Blog\Admin\CategoryController;
use App\Http\Middleware\DashboardMiddleware;
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



require __DIR__.'/auth.php';

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(DashboardMiddleware::class)
    ->name('dashboard');

Route::get('main', [PostsController::class, 'mainPage'])->name('main');
Route::get('show/{id}',[PostsController::class, 'show'])->name('show');
Route::get('/', function () {
    return redirect(route('main'));
});

//Адмінка
$groupData = ['prefix' => 'admin/blog'];

//Category
Route::group($groupData, function() {
    $methods = ['index', 'edit' , 'create','store', 'update', ];
    Route::resource('categories', CategoryController::class)
        ->middleware(DashboardMiddleware::class)
        ->only($methods)
        ->names('blog.admin.categories');
    Route::get('show/categorypost', [DashboardController::class, 'categoryPosts'])
        ->middleware(DashboardMiddleware::class)->name('categories');
    Route::get('show/categoryposts/{id}', [DashboardController::class, 'getPosts'])
        ->middleware(DashboardMiddleware::class)->name('categoryPosts');

//Posts
    Route::resource('posts', PostsController::class)
        ->middleware(DashboardMiddleware::class)
        ->except(['show'])
        ->names('blog.admin.posts');
    Route::get('posts/published', [DashboardController::class, 'published'])
        ->middleware(DashboardMiddleware::class)->name('published');
    Route::get('posts/deleted', [DashboardController::class, 'deleted'])
        ->middleware(DashboardMiddleware::class)->name('deleted');
    Route::get('posts/not_published', [DashboardController::class, 'notPublished'])
        ->middleware(DashboardMiddleware::class)->name('not_published');
});
