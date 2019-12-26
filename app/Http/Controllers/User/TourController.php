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
//        $tours = $this->tourRepository->getToursForIndexPage();
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
    public function show($id)
    {
        $tour = $this->tourRepository->getShowTour($id);
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
}
