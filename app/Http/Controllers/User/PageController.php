<?php

namespace App\Http\Controllers\User;

use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    protected $pageRepository;
    protected $settingsRepository;
    protected $tourRepository;

    public function __construct()
    {
        $this->pageRepository = new PageRepository();
        $this->settingsRepository = new SettingsRepository();
        $this->tourRepository = new TourRepository();
    }

    public function show($id)
    {
        $page = $this->pageRepository->getShowPage($id);
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();

        if (!empty($page) == true && $page->is_published == true && $page->nav_name == "Календарь туров") {
            $dates = $this->tourRepository->getToursForCalendarTableIndexPage();
            return view('frontend.page.pageTimeTable', compact('page', 'pageItems', 'data', 'pagesFooterInfo', 'dates'));
        } elseif (!empty($page) == true && $page->is_published == true) {
            return view('frontend.page.page', compact('page', 'pageItems', 'data', 'pagesFooterInfo'));
        } else {
            return abort(404);
        }
    }
}
