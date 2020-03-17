<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourAddRequest;
use App\Http\Requests\TourUpdateRequest;
use App\Models\Gallery;
use App\Models\Tour;
use App\Models\TourCalendar;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\PageRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\TourCalendarRepository;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class TourController extends Controller
{
    protected $tourRepository;
    protected $categoryRepository;
    protected $galleryRepository;
    protected $tourCalendarRepository;
    protected $pageRepository;
    protected $scopeRepository;

    public function __construct()
    {
        $this->tourRepository = new TourRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->galleryRepository = new GalleryRepository();
        $this->tourCalendarRepository = new TourCalendarRepository();
        $this->pageRepository = new PageRepository();
        $this->scopeRepository = new ScopeRepository();
    }

    public function dashboard()
    {
        return view('admin.page.manager.tour.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        if ($user->can('viewAny', Tour::class)) {
            $tours = $this->tourRepository->getAllTours();

            return view('admin.page.manager.tour.list', compact('tours'));
        } else {
            return abort(404);
        }
    }

    public function indexCurrentCategory($id)
    {
        $tours = $this->tourRepository->startConditions()
            ->with(['categories' => function ($query) use ($id) {
                $query->select('id', 'title')
                    ->where('id', $id);
            },
                'gallery' => function ($query) use ($id) {
                    $query->select('id', 'tour_id', 'path', 'is_header')
                        ->where('is_header', 'true');
                }])
            ->get()
            ->filter(function ($value) {
                return $value->categories->isNotEmpty();
            });

        $tours = $this->tourRepository->getPathSizeImgForTours($tours, 'small');

        return view('admin.page.manager.tour.list', compact('tours'));
    }

    public function indexCurrentScope($id)
    {
        $tours = $this->tourRepository->startConditions()
            ->with(['scope' => function ($query) use ($id) {
                $query->select('id', 'title')
                    ->where('id', $id);
            },
                'gallery' => function ($query) use ($id) {
                    $query->select('id', 'tour_id', 'path', 'is_header')
                        ->where('is_header', 'true');
                }])
            ->get()
            ->filter(function ($value) {
                if (!empty($value->scope)) {
                    return true;
                }
                else {
                    return false;
                }
            });

        $tours = $this->tourRepository->getPathSizeImgForTours($tours, 'small');

        return view('admin.page.manager.tour.list', compact('tours'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $delimiter = '';

        if ($user->can('viewAny', Tour::class)) {
            $categories = $this->categoryRepository->getAllCategoriesForHierarchicalView();
            $allScopes = $this->scopeRepository->getAll();


            return view('admin.page.manager.tour.add', compact('categories', 'allScopes', 'delimiter'));
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
    public function store(TourAddRequest $request)
    {
        if ($this->tourRepository->isIdenticalTitle($request->title) == false) {
            $data = $request->except(['categoriesId', 'uploadPhotos']);
            $data['slug'] = Str::slug($request->title);
            $data['user_id'] = Auth::user()->id;

            $tour = $this->tourRepository->startConditions()->create($data);

            $categories = $request->input()['categoriesId'];
            $tour->categories()->attach($categories);

            $imgFiles = $request->file('uploadPhotos');
            $this->saveImgFile($imgFiles, $tour, $i = 0);

            $file = $request->file('file_path');
            $fileName = $request->input('file_name');
            if(!empty($file)) {
                $this->saveFile($file, $fileName, $tour);
            }


            return redirect()
                ->route('manager.tour.edit', $tour->id)
                ->with(['success' => 'Тур добавлен']);

        } else {
            return redirect()
                ->route('manager.tour.create')
                ->withErrors('Тур с таким названием уже существует')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tour = $this->tourRepository->getShowTour($id);
        $pageItems = $this->pageRepository->getPagesItems();

        if (!empty($tour == true)) {

            return view('frontend.page.tour', compact('tour', 'pageItems'));
        } else {
            return abort('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->can('viewAny', Tour::class)) {
            $tour = $this->tourRepository->getEdit($id);
            $selectCategories = $this->tourRepository->getSelectCategories($tour);
            $photos = $this->tourRepository->getAllPhotos($tour, 'small');
            $user = $this->tourRepository->getUser($tour);
            $categories = $this->categoryRepository->getAllCategoriesForHierarchicalView();
            $dates = $this->tourCalendarRepository->getAllDatesForTour($id);
            $allScopes = $this->scopeRepository->getAll();
            $selectScope = $this->scopeRepository->getSelectScope($tour);
            $delimiter = '';

            return view('admin.page.manager.tour.edit', compact('tour', 'selectCategories',
                'photos', 'dates', 'categories', 'user', 'allScopes', 'selectScope', 'delimiter'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TourUpdateRequest $request, $id)
    {
        $data = $request->except(['categoriesId', 'GalleryHeaderPhotoId', 'deletePhoto']);
        $data['user_id'] = Auth::user()->id;
        if (empty($request->input('is_published'))) {
            $data['is_published'] = false;
        }
        $tour = $this->tourRepository->getEdit($id);
        $categoriesId = $request->categoriesId;

        if (empty($data['dates'])) {
            $data['dates'] = null;
        }

        $this->saveCalendar($tour, $data['dates']);

        $tour->update($data);
        $tour->categories()->sync($categoriesId);

        $imgFiles = $request->file('uploadPhotos');
        if ($imgFiles) {
            $this->saveImgFile($imgFiles, $tour);
        }

        $file = $request->file('file_path');
        $fileName = $request->input('file_name');

        if(!empty($fileName)) {
            $this->saveFile($file, $fileName, $tour);
        }

        $galleryHeaderPhotoId = $request->input('GalleryHeaderPhotoId');
        $currentHeaderPhotoId = $this->tourRepository->getCurrentIdHeaderPhoto($tour);

        if(!empty($galleryHeaderPhotoId) && !empty($currentHeaderPhotoId) && ($galleryHeaderPhotoId != $currentHeaderPhotoId)) {
            $currentGallery = $this->galleryRepository->getEdit($currentHeaderPhotoId);
            $currentGallery->is_header = false;
            $currentGallery->save();

            $headerGallery = $this->galleryRepository->getEdit($galleryHeaderPhotoId);
            $headerGallery->is_header = true;
            $headerGallery->save();
        }
        elseif (!empty($galleryHeaderPhotoId) && empty($currentHeaderPhotoId)) {
            $headerGallery = $this->galleryRepository->getEdit($galleryHeaderPhotoId);
            $headerGallery->is_header = true;
            $headerGallery->save();
        }

        $deletePhotoId = $request->input('deletePhoto');
        if ($deletePhotoId) {
            $this->deleteImgFile($deletePhotoId);
        }


        return redirect()
            ->route('manager.tour.edit', $id)
            ->with(['success' => 'Тур успешно обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tour::destroy($id);

        return redirect()
            ->route('manager.tour.index')
            ->with(['success' => 'Тур удален']);
    }

    public function publishing(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->can('viewAny', Tour::class)) {
            $tour = $this->tourRepository->getEdit($id);
            if ($request->input('is_published') == 1) {
                $tour->is_published = true;
                $tour->save();
            } else {
                $tour->is_published = false;
                $tour->save();
            }

            return redirect()
                ->route('manager.tour.index')
                ->with(['success' => 'Статус публикации тура изменен']);
        }
    }

    protected function saveCalendar($tour, $dates)
    {
        if ($dates != null) {
            foreach ($dates as $date) {
                if (empty($date['comment'])) {
                    $date['comment'] = null;
                }
                $raspisanie[] = new TourCalendar([
                                                'start' => $date['start'],
                                                'finish' => $date['finish'],
                                                'comment' => $date['comment']
                                                ]);
            }
            $tour->calendar()->delete();
            $tour->calendar()->saveMany($raspisanie);
        } else {
            $tour->calendar()->delete();
        }
    }

    protected function saveImgFile($imgFiles, $tour, $i = 1)
    {
        $imageHelper = new ImageHelper();
        foreach ($imgFiles as $img) {
            $path = $imageHelper->saveImgFile($img, $tour);

            if ($i == 0) {
                $paths[] = new Gallery(['path' => $path . '.jpg', 'is_header' => true]);
            } else {
                $paths[] = new Gallery(['path' => $path . '.jpg']);
            }
            $i++;
        }

        $tour->gallery()->saveMany($paths);
    }

    protected function deleteImgFile($deletePhotoId)
    {
        $paths = $this->galleryRepository->getPathsPhotos($deletePhotoId);
        $pathDir = 'public/' .substr($paths[0] , 0, strripos($paths[0], '/'));

        $files = Storage::allFiles($pathDir);
        foreach ($paths as $path) {
            foreach ($files as $file) {
                $imgName = substr($path, strripos($path, '/') + 1);
                $imgName = substr($imgName, 0, strripos($imgName, '.'));
                $posCount = strpos($file, $imgName);
                if (strpos($file, $imgName) != false) {
                    $deleteFiles[] = $file;
                }
                }

            if($deleteFiles) {
                foreach ($deleteFiles as $item) {
                    $item = substr($item, strpos($item, '/') +1);
                    Storage::disk('public')->delete($item);
                }
            }
        }
        Gallery::destroy($deletePhotoId);
    }

    protected function saveFile($file, $fileName, $tour)
    {
        $uploadsDir = 'uploads/tour_' . $tour->id . '/file';
        Storage::deleteDirectory($uploadsDir);
        Storage::disk('public')->makeDirectory($uploadsDir);

        if(!empty($file)) {
            $path = $file->store($uploadsDir, 'public');

            if(!empty($fileName)) {
                $data = [
                    'file_path' => $path,
                    'file_name' => $fileName
                ];
            }
            else {
                $data = [
                    'file_path' => $path,
                ];
            }
        }
        else {
            if(!empty($fileName)) {
                $data = [
                    'file_name' => $fileName
                ];
            }
            else {
                return;
            }
        }

        $tour->update($data);
    }
}