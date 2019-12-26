<?php

namespace App\Repositories;

use App\Models\Category as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
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
            ->with(['tours:id', 'gallery:id,category_id,path', 'children'])
            ->where('parent_id', 0)
            ->get();

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
        return $tours;
    }

    public function getCategoriesForIndexPage()
    {
        $categories = $this->startConditions()
            ->select('id', 'parent_id', 'title', 'description')
            ->where('parent_id', 0)
            ->with(['tours', 'gallery:id,category_id,path'])
            ->orderBy('title')
            ->get();

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

        return $childCats;
    }
}