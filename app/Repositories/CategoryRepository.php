<?php

namespace App\Repositories;

use App\Models\Category as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryRepository extends CoreRepository
{
    protected $tourRepository;

    public function __construct()
    {
        parent::__construct();
        $this->tourRepository = new TourRepository();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        $category = $this->startConditions()
            ->select('id', 'title', 'slug', 'description', 'parent_id', 'description_img')
            ->where('id', $id)
            ->first();

        return $category;
    }

    public function isIdenticalTitle($title, $id = false)
    {
        $slugs = DB::table('categories')->pluck('slug');
        $currentSlug = Str::slug($title);

        if ($slugs->contains($currentSlug)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCategories()
    {
        $categories = $this->startConditions()
            ->select('id', 'parent_id', 'title', 'description')
            ->with(['tours:id', 'gallery:id,category_id,path', 'children'])
            ->get();

        return $categories;
    }

    public function getAllCategoriesForHierarchicalView()
    {
        $categories = $this->startConditions()
            ->select('id', 'parent_id', 'title', 'description', 'description_img')
            ->with(['tours:id', 'gallery:id,category_id,path', 'children.gallery:id,category_id,path'])
            ->where('parent_id', 0)
            ->get();

        $categories = $this->getPathCropSmallImgForCategories($categories);

        return $categories;

    }

    public function getAllPublishedTourCurrentCategory($id)
    {
        $tours = $this->startConditions()
            ->select('id', 'title', 'slug', 'description')
            ->where('id', $id)
            ->with(['tours' => function ($query) {
                $query->select('id', 'title', 'slug', 'price', 'description', 'sale', 'description_cat', 'is_published')
                    ->where('is_published', true)
                    ->orderBy('title');
            },
                'tours.gallery' => function ($query) {
                    $query->select('id', 'tour_id', 'path', 'is_header')
                        ->where('is_header', true);
                }
            ])
            ->first()
            ->tours;

        $tours = $this->tourRepository->getPathSizeImgForTours($tours, 'small');

        return $tours;
    }

    public function getCategoriesForIndexPage()
    {
        $categories = $this->startConditions()
            ->select('id', 'parent_id', 'title', 'description', 'slug')
            ->where('parent_id', 0)
            ->with(['tours', 'gallery:id,category_id,path'])
            ->orderBy('title')
            ->get();

        $categories = $this->getPathCropSmallImgForCategories($categories);

        foreach ($categories as $category) {
            if ($category->tours->count() > 0) {
                $notEmptyCategories[] = $category;
            }
        }

        if (empty($notEmptyCategories)) {
            $notEmptyCategories = null;
        }

        return $categories;

    }

    public function childrenCategories($category)
    {
        $childCats = $category->children()
            ->select('id', 'title', 'slug', 'description')
            ->with(['gallery' => function($query) {
                $query->select('id', 'category_id', 'path');
            }, 'children:id,parent_id', 'tours:id,category_id'])
            ->get();

        $childCats = $this->getPathCropSmallImgForCategories($childCats);

        return $childCats;
    }

    public function getIdCategoryFromSlug($slug) {
        $id = $this->startConditions()
            ->select('id', 'slug')
            ->where('slug', $slug)
            ->pluck('id')
            ->first();

        return $id;
    }

    /**
     * @param $categories
     * @return mixed
     */
    protected function getPathCropSmallImgForCategories($categories) {
        $categories->map(function ($item) {
            $path = $item->gallery->first()->path;
            $pathCrop = substr($path, 0, stripos($path, '.')) . '_small.jpg';

            if (Storage::disk('public')->exists($pathCrop)) {
                $item->gallery->first()->path = $pathCrop;
            }

            $childCategories = $item->children;
            if ($childCategories->count() > 0) {
                $childCategories->map(function ($itemChild) {
                    $path = $itemChild->gallery->first()->path;
                    $pathCrop = substr($path, 0, stripos($path, '.')) . '_small.jpg';

                    if (Storage::disk('public')->exists($pathCrop)) {
                        $itemChild->gallery->first()->path = $pathCrop;
                        return $itemChild;
                    }
                });
            };

            return $item;
        });

        return $categories;
    }


    /**
     * @param $category
     * @return mixed
     */
    public function getPathCropLargeImgForCategories($category) {
        $path = $category->gallery->first()->path;
        $pathCrop = substr($path, 0, stripos($path, '.')) . '_large.jpg';

        if (Storage::disk('public')->exists($pathCrop)) {
            $category->gallery->first()->path = $pathCrop;
        }

        return $category;
    }
}
