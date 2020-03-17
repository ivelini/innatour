<?php

namespace App\Http\Controllers\User;

use App\Repositories\CaruselRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\TourRepository;
use App\Http\Controllers\Controller;

class TourController extends Controller
{
    protected $tourRepository;
    protected $categoryRepository;
    protected $caruselRepository;
    protected $settingsRepository;
    protected $pageRepository;

    public function __construct()
    {
        $this->tourRepository = new TourRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->caruselRepository = new CaruselRepository();
        $this->settingsRepository = new SettingsRepository();
        $this->pageRepository = new PageRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dates = $this->tourRepository->getToursForCalendarTableIndexPage();
        $categories = $this->categoryRepository->getCategoriesForIndexPage();
        $caruselItems = $this->caruselRepository->getCaruselItems();
        $tourSearchForm = $this->settingsRepository->getTourSearchForm();
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();

        return view('frontend.page.index', compact('categories', 'dates',
            'caruselItems',
            'tourSearchForm',
            'pageItems',
            'data',
            'pagesFooterInfo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (is_numeric($slug)) {
            $id = $slug;
            $tour = $this->tourRepository->getShowTour($id);

            return redirect(route('tour.show', $tour->slug), 301);
        }
        else {
            $id =  $this->tourRepository->getIdTourFromSlug($slug);
        }
        $tour = $this->tourRepository->getShowTour($id);
        $tour = $this->tourRepository->getPathSizeImgesForTour($tour, 'medium');
        $tour = $this->tourRepository->assignIs_headerPathImage($tour);
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();
        $dates = $this->tourRepository->getCalendarTableForTour($id);

        if (!empty($tour) == true && $tour->is_published == true) {

            return view('frontend.page.tour', compact('tour', 'pageItems',
                'data', 'pagesFooterInfo', 'dates'));
        }
        else {
            return abort(404);
        }
    }

    public function test() {
        $files = \Storage::allFiles('public');

        foreach ($files as $item) {
            $format = substr($item, stripos($item, '.'));

            if ($format == '.jpg') {
                $path = substr($item, 0, strripos($item, '.'));
                $uploadsDir = substr($item, 0, strripos($item, '/'));
                \Storage::disk('public')->makeDirectory($uploadsDir);

                $itemImgFull = \Image::make(\Storage::path($item));
                $itemImgCrop = clone $itemImgFull;
                $imgData = $itemImgCrop->exif();
                $imgWidth = $imgData['COMPUTED']['Width'];
                $imgHeight = $imgData['COMPUTED']['Height'];

                $imgRatio = round($imgWidth / $imgHeight, 2);

                $size = [
                    'small' => 400,
                    'medium' => 800
                ];

                $ratio = 1.65;
                $nameModel = 'category';
                do {
                    if ($imgRatio < $ratio) {
                        $imgHeightCrop = round($imgWidth / $ratio, 0);
                        $itemImgCrop->crop($imgWidth, $imgHeightCrop, 0, round(($imgHeight - $imgHeightCrop) / 2, 0));
                    } elseif ($imgRatio > $ratio) {
                        $imgWidthCrop = round($imgHeight * $ratio, 0);
                        $itemImgCrop->crop($imgWidthCrop, $imgHeight, round(($imgWidth - $imgWidthCrop) / 2, 0), 0);
                    }

                    foreach ($size as $key => $item) {
                        $itemImgCropSize = clone $itemImgCrop;
                        $itemImgCropSize->resize($item, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $pathCrop = $path . '_' . $key;
                        $itemImgCropSize->save(storage_path() . '/app/public/' . $pathCrop . '.jpg', 90);
                    }

                    if (key($size) == 'large') {
                        break;
                    }
                    $itemImgCrop = clone $itemImgFull;
                    $ratio = 3.5;
                    $size = ['large' => 1800];
                } while ($nameModel == 'category');
            }
        }
    }
}
