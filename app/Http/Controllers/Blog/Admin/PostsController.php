<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Repositories\Blog\PostRepository;
use App\Repositories\Blog\CategoryRepository;

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
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $item = new Post();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new Post())->create($data);

        if($item){
            return redirect()
                ->route('blog.admin.posts.edit', [$item->id])
                ->with(['success' => 'Успішно збережено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Помилка зберігання'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if(empty($item)){
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
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
        $item = $this->blogPostRepository->getEdit($id);
        $data = $request->all();


        if(empty($item)){
            return back()
                ->withErrors(['msg'=> "Запис id = [{$id}] не знайдено"])
                ->withInput();
        }
        $result = $item->update($data);
        if($result){
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успішно збережено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Помилка зберігання'])
                ->withInput();
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
        $result = Post::destroy($id);
        if($result){

            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success' => "Запис id [$id] успішно видалено"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Помилка видалення']);
        }

    }
}
