<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $BlogCategoryRepository;

    public function __construct(){

        $this->BlogCategoryRepository = app(CategoryRepository::class);
    }

    public function index()
    {
        $paginator = $this->BlogCategoryRepository->getAllWithPaginate(10);
        return view('blog.admin.category.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $item = new Category();
            $categoryList = $this->BlogCategoryRepository->getForComboBox();

            return view('blog.admin.category.edit', compact('item', 'categoryList'));
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
    public function store(CategoryCreateRequest $request)
    {
        if(Auth::check() && (Auth::user()->role_id == 1)) {

            $data = $request->input();
            $item = (new Category())->create($data);

            if ($item) {
                return redirect()
                    ->route('blog.admin.categories.edit', [$item->id])
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, CategoryRepository $categoryRepository)
    {
        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $item = $this->BlogCategoryRepository->getEdit($id);
            if (empty($item)) {
                abort(404);
            }

            $categoryList = $categoryRepository->getForComboBox();

            return view('blog.admin.category.edit', compact('item', 'categoryList'));
        }else{
            return view('blog.access_denied401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, CategoryUpdateRequest $request)
    {
        if(Auth::check() && (Auth::user()->role_id == 1)) {
            $item = $this->BlogCategoryRepository->getEdit($id);

            if (empty($item)) {
                return back()
                    ->withErrors(['msg' => "Запис id = [{$id}] не знайдено"])
                    ->withInput();
            }

            $data = $request->all();
            $result = $item->update($data);

            if ($result) {
                return redirect()
                    ->route('blog.admin.categories.edit', $item->id)
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
