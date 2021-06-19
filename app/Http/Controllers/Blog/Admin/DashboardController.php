<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Blog\CategoryRepository;
use App\Repositories\Blog\PostRepository;
use App\Models\Post;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $blogPostRepository;

    private $blogCategoryRepository;

    public function __construct()
    {

        $this->blogPostRepository = app(PostRepository::class);
        $this->blogCategoryRepository = app(CategoryRepository::class);
    }

    public function dashboard(){

        $categories = Category::LastCategories(5);
        $posts = Post::LastPosts(5);
        return view('blog.admin.Dashboard', compact(['categories', 'posts']));
    }

    public function categoryPosts(){
        $categories = $this->blogCategoryRepository->getAllWithPaginate();
        return view('blog.admin.category.categories', compact('categories'));
    }
    public function getPosts($id){
        $posts = $this->blogPostRepository->postCategory($id);

        return view('blog.admin.category.category_posts', compact('posts'));
    }

}
