<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Blog\PostRepository;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Support\Facades\Auth;




class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $blogPostRepository;

    private $blogCategoryRepository;

    public function __construct()
    {

        $this->blogPostRepository = app(PostRepository::class);
        $this->blogCategoryRepository = app(CategoryRepository::class);
    }
    public function published(){
       $posts = $this->blogPostRepository->isPublished();
       return view('blog.admin.posts.published_posts', compact('posts'));
    }
    public function notPublished()
    {
        $posts = $this->blogPostRepository->notPublished();
        return view('blog.admin.posts.notpublished_posts', compact('posts'));
    }
    public function deleted(){
        $posts = $this->blogPostRepository->deleted();

        return view('blog.admin.posts.deleted_posts', compact('posts'));
    }
    public function mainPage(){
        $posts = $this->blogPostRepository->getLastPostsPaginate();
        return view('blog.user.main_page', compact('posts'));
    }
    public function index()
    {
        $posts = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $item = new Post();
            $categoryList = $this->blogCategoryRepository->getForComboBox();

            return view('blog.admin.posts.edit', compact('item', 'categoryList'));
        }else{
           return redirect(route('blog.admin.posts.index'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        if(Auth::check()) {
            $data = $request->input();
            $user = ['user_id' => Auth::user()->id];
            $result = array_merge($user, $data);

            $item = (new Post())->create($result);

            if ($item) {
                return redirect()
                    ->route('blog.admin.posts.edit', [$item->id])
                    ->with(['success' => 'Успішно збережено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Помилка зберігання'])
                    ->withInput();
            }
        }else{
            return redirect(route('blog.admin.posts.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->blogPostRepository->getEdit($id);

        return view('blog.user.show_post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if(Auth::check()) {
            $item = $this->blogPostRepository->getEdit($id);
            if (empty($item)) {
                abort(404);
            }

            $categoryList = $this->blogCategoryRepository->getForComboBox();

            return view('blog.admin.posts.edit', compact('item', 'categoryList'));
        }else{
            return redirect(route('blog.admin.posts.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, PostUpdateRequest $request)
    {
        if(Auth::check()) {
            $item = $this->blogPostRepository->getEdit($id);
            $data = $request->all();


            if (empty($item)) {
                return back()
                    ->withErrors(['msg' => "Запис id = [{$id}] не знайдено"])
                    ->withInput();
            }
            $result = $item->update($data);
            if ($result) {
                return redirect()
                    ->route('blog.admin.posts.edit', $item->id)
                    ->with(['success' => 'Успішно збережено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Помилка зберігання'])
                    ->withInput();
            }
        }else{
            return redirect(route('blog.admin.posts.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Auth::check()) {
            $result = Post::destroy($id);
            if ($result) {

                return redirect()
                    ->route('blog.admin.posts.index')
                    ->with(['success' => "Запис id [$id] успішно видалено"]);
            } else {
                return back()
                    ->withErrors(['msg' => 'Помилка видалення']);
            }
        }else{
            return redirect(route('blog.admin.posts.index'));
        }
    }
}
