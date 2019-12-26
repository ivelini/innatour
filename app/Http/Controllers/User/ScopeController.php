<?php

namespace App\Http\Controllers\User;

use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScopeController extends Controller
{
    protected $categoryRepository;
    protected $pageRepository;
    protected $settingsRepository;
    protected $scopeRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->pageRepository = new PageRepository();
        $this->settingsRepository = new SettingsRepository();
        $this->scopeRepository = new ScopeRepository();
    }

    public function indexCurrentScope($id) {

        $scope = $this->scopeRepository->getEdit($id);
        $tours = $this->scopeRepository->getAllPublishedTourCurrentScope($id);
        $paginate['toursCount'] = $tours->count();
        $paginate['countToursForPage'] = 9;
        $paginate['countPaginate'] = ceil($paginate['toursCount'] / $paginate['countToursForPage']);
        $paginate['currentPage'] = !empty($_GET['page']) ? $_GET['page'] : 1;
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();

        $tours = $tours->forPage( $paginate['currentPage'], $paginate['countToursForPage']);

        return view('frontend.page.scope', compact('tours', 'paginate',
            'scope',
            'pageItems',
            'data',
            'pagesFooterInfo'));

    }
}
