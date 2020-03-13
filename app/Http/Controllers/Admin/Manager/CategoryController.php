<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        if ($user->can('index', Category::class)) {
            $categories = $this->categoryRepository->getAllCategoriesForHierarchicalView();
            $delimiter = '';

            return view('admin.page.manager.tour.categoryList', compact('categories', 'delimiter'));
        } else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->input();

        if ($this->categoryRepository->isIdenticalTitle($request['title']) == false) {
            $category = new Category($data);
            $category->save();

            $img = $request->file('cat_img');
            if ($img) {
                $imageHelper = new ImageHelper();
                $path = $imageHelper->saveImgFile($img, $category);

                $path = new Gallery(['path' => $path . '.jpg']);
                $category->gallery()->delete();
                $category->gallery()->save($path);
            }

            return redirect()
                ->route('manager.category.index')
                ->with(['success' => 'Категория добавлена']);
        } else {
            return redirect()
                ->route('manager.category.index')
                ->withErrors('Категория с таким названием существует');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->slug = Str::slug($request->title);
        $category->description = $request->description;
        $category->description_img = $request->description_img;
        $category->save();

        $img = $request->file('cat_img');
        if ($img) {
            $imageHelper = new ImageHelper();
            $path = $imageHelper->saveImgFile($img, $category);

            $path = new Gallery(['path' => $path . '.jpg']);
            $category->gallery()->delete();
            $category->gallery()->save($path);
        }

        return redirect()
            ->route('manager.category.index')
            ->with(['success' => 'Категория обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toursCount = $this->categoryRepository->getEdit($id)
            ->tours()
            ->get()
            ->count();

        if ($toursCount > 0) {
            return redirect()
                ->route('manager.category.index')
                ->withErrors(['Категория не может быть удалена, так как содержит туры. Сначала переместите туры в другую категорию.']);
        }
        else {
            Category::destroy($id);
            return redirect()
                ->route('manager.category.index')
                ->with(['success' => 'Категория удалена']);
        }
    }
}
