<?php

namespace App\Http\Controllers\User;

use App\Repositories\CategoryRepository;
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
    protected $categoryRepository;

    public function __construct()
    {
        $this->pageRepository = new PageRepository();
        $this->settingsRepository = new SettingsRepository();
        $this->tourRepository = new TourRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    public function show($slug)
    {
        if (is_numeric($slug)) {
            $id = $slug;
            $page = $this->pageRepository->getShowPage($id);

            return redirect(route('page.show', $page->slug), 301);
        }
        else {
            $id =  $this->pageRepository->getIdPageFromSlug($slug);
        }

        $page = $this->pageRepository->getShowPage($id);
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();

        if (!empty($page) == true && $page->is_published == true && $page->nav_name == "Календарь туров") {
            $dates = $this->tourRepository->getToursForCalendarTableIndexPage();
            return view('frontend.page.pageTimeTable', compact('page', 'pageItems', 'data', 'pagesFooterInfo', 'dates'));
        }  elseif (!empty($page) == true && $page->is_published == true && $page->nav_name == "Карта сайта") {
            $sitemap = $this->categoryRepository->getAllCategoriesAndToursForSitemap();
            return view('frontend.page.sitemap', compact('page', 'pageItems', 'data', 'pagesFooterInfo', 'sitemap'));
        } elseif (!empty($page) == true && $page->is_published == true) {
            return view('frontend.page.page', compact('page', 'pageItems', 'data', 'pagesFooterInfo'));
        } else {
            return abort(404);
        }
    }
}
