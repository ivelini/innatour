<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\SettingsRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $pageRepository;
    protected $settingsRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->pageRepository = new PageRepository();
        $this->settingsRepository = new SettingsRepository();
    }

    public function show($slug)
    {
        $this->categoryRepository->getAllCategoriesAndToursForSitemap();
        if (is_numeric($slug)) {
            $id = $slug;
            $category = $this->categoryRepository->getEdit($id);

            return redirect(route('category.indexCurrentCategory', $category->slug), 301);
        }
        else {
            $id =  $this->categoryRepository->getIdCategoryFromSlug($slug);
        }

        $category = $this->categoryRepository->getEdit($id);
        $category = $this->categoryRepository->setPatImgForOpenGraph($category);
        $category = $this->categoryRepository->getPathCropLargeImgForCategories($category);
        $childCats = $this->categoryRepository->childrenCategories($category);
        $tours = $this->categoryRepository->getAllPublishedTourCurrentCategory($id);
        $paginate['toursCount'] = $tours->count();
        $paginate['countToursForPage'] = 9;
        $paginate['countPaginate'] = ceil($paginate['toursCount'] / $paginate['countToursForPage']);
        $paginate['currentPage'] = !empty($_GET['page']) ? $_GET['page'] : 1;
        $pageItems = $this->pageRepository->getPagesItemsForIndex();
        $data = $this->settingsRepository->getSettingsData();
        $pagesFooterInfo = $this->pageRepository->getPagesForFooterInfo();

        $tours = $tours->forPage( $paginate['currentPage'], $paginate['countToursForPage']);

        return view('frontend.page.category', compact('tours', 'paginate',
            'category',
            'childCats',
            'pageItems',
            'data',
            'pagesFooterInfo'));
    }
}
