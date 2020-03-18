<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Requests\PageRequest;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\User;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PageController extends Controller
{
    protected $pageRepository;

    public  function __construct()
    {
        $this->pageRepository = new PageRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageRepository->getAllPages();

        return view('admin.page.manager.pages.list', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('admin.page.manager.pages.add', ['locations' => $this->pageRepository->locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {

        if ($this->pageRepository->isIdenticalTitle($request->title) == false) {
            $data = $request->except(['pageImg']);
            $data['slug'] = Str::slug($request->title);



            if(!empty($request->input('location'))) {
                $data['location'] = $request->input('location');
            }

            $page = $this->pageRepository->startConditions()->create($data);

            $imgFiles = $request->file('pageImg');
            $this->saveImgFile($imgFiles, $page, $i = 0);


            return redirect()
                ->route('manager.page.edit', $page->id)
                ->with(['success' => 'Страница добавлена']);

        } else {
            return redirect()
                ->route('manager.tour.create')
                ->withErrors('Страница с таким названием уже существует')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->getEdit($id);
        $photo = $this->pageRepository->getPhoto($page);

       $locations = [
            'top_menu' => 'Верхнее меню',
            'footer_info' => 'Меню информации (в подвале)',
            'link' => 'По ссылке'
        ];

        return view('admin.page.manager.pages.edit', compact('page', 'photo', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        $data = $request->except(['pageImg']);
        if (empty($request->input('is_published'))) {
            $data['is_published'] = false;
        }
        $page = $this->pageRepository->getEdit($id);

        $page->update($data);


        $imgFiles = $request->file('pageImg');
        if ($imgFiles) {
            $this->saveImgFile($imgFiles, $page);
        }

        return redirect()
            ->route('manager.page.edit', $id)
            ->with(['success' => 'Страница успешно обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);

        return redirect()
            ->route('manager.page.index')
            ->with(['success' => 'Страница удалена']);
    }

    protected function saveImgFile($img, $page)
    {
        $uploadsDir = 'uploads/page_' . $page->id . '/img';
        Storage::disk('public')->makeDirectory($uploadsDir);
        $path = $uploadsDir . '/' . Str::random(15) . '.jpg';

        Image::make($img)->save(storage_path() . '/app/public/' . $path, 90);

        $galleryModel = new Gallery();

        $findPath = $galleryModel->where('page_id', $page->id)->first();

//        dd(__METHOD__, $findPath);

        if(!empty($findPath)) {
            $findPath->delete();
        }

        $paths = new Gallery(['path' => $path]);
        $page->gallery()->save($paths);
    }
}
