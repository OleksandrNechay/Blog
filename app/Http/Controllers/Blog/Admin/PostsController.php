<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Photo;
use App\Models\Post;

use App\Repositories\Blog\PhotoRepository;
use App\Repositories\Blog\PostRepository;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;





class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $blogPostRepository;

    private $blogCategoryRepository;
    private $blogPhotoRepository;

    public function __construct()
    {
        $this->blogPhotoRepository = app(PhotoRepository::class);
        $this->blogPostRepository = app(PostRepository::class);
        $this->blogCategoryRepository = app(CategoryRepository::class);
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
           return view('blog.access_denied401');
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
        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $data = $request->input();
            $user = ['user_id' => Auth::user()->id];
            $result = array_merge($user, $data);
            $post = (new Post())->create($result);


            $file = $request->file('image');
            if(isset($file)) {
                $img = $request->file('image')->store('images', 'public');
                $name = $file->getClientOriginalName();
                $url = Str::slug($name);

                $image = ['post_id'=> $post->id, 'photos_name' => $name,'photo_url' => $url, 'photo_path' => $img];

                $img = (new Photo())->create($image);
            }

            if ($post) {
                return redirect()
                    ->route('blog.admin.posts.edit', [$post->id])
                    ->with(['success' => 'Успішно збережено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Помилка зберігання'])
                    ->withInput();
            }
        }else{
            return view('blog.access_denied401');
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
       // $img = $this->blogPhotoRepository->getPhoto($id);
        $img = Photo::select('photo_path')
            ->where('post_id', $id)
            ->join('posts', 'posts.id', 'photos.id')
            ->first();

        return view('blog.user.show_post', compact(['post', 'img']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $item = $this->blogPostRepository->getEdit($id);
            if (empty($item)) {
                abort(404);
            }

            $categoryList = $this->blogCategoryRepository->getForComboBox();

            return view('blog.admin.posts.edit', compact('item', 'categoryList'));
        }else{
            return view('blog.access_denied401');
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
        if(Auth::check() && (Auth::user()->role_id == 1)) {
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
            return view('blog.access_denied401');
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
        if(Auth::check() && (Auth::user()->role_id == 1)) {
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
            return view('blog.access_denied401');
        }
    }
}
