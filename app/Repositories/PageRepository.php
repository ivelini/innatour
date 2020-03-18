<?php

namespace App\Repositories;

use App\Models\Page as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageRepository extends CoreRepository
{
    public $locations;
    public function __construct()
    {
        parent::__construct();
        $this->locations = [
            'top_menu' => 'Верхнее меню',
            'footer_info' => 'Меню информации (в подвале)',
            'link' => 'По ссылке'
        ];
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getAllPages()
    {
        $pages = $this->startConditions()
            ->select('id', 'title', 'location', 'is_published')
            ->with(['gallery' => function ($query) {
                $query->select('id', 'page_id', 'path');
            }])
            ->get();

        foreach($pages as $page) {
            if(!empty($page->location)) {
                $page->location = $this->locations[$page->location];
            }
        }

        return $pages;
    }

    public function isIdenticalTitle($title, $id = false)
    {
        $slugs = DB::table('pages')->pluck('slug');
        $currentSlug = Str::slug($title);

        if ($slugs->contains($currentSlug)) {
            return true;
        } else {
            return false;
        }
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getPhoto($page)
    {
        $photos = $page->gallery()
            ->select('id', 'page_id', 'path')
            ->first();

        return $photos;
    }

    public function getPagesItems()
    {
        $pages = $this->startConditions()
            ->select('id', 'nav_name', 'title', 'location', 'is_published')
            ->with(['gallery' => function ($query) {
                $query->select('id', 'page_id', 'path');
            }])
            ->get();

        return $pages;
    }

    public function getPagesItemsForIndex()
    {
        $pages = $this->startConditions()
            ->select('id', 'nav_name', 'title', 'slug', 'location', 'is_published')
            ->where('is_published', true)
            ->where('location', '=', 'top_menu')
            ->with(['gallery' => function ($query) {
                $query->select('id', 'page_id', 'path');
            }])
            ->get();

        return $pages;
    }

    public function getPagesForFooterInfo()
    {
        $pages = $this->startConditions()
            ->select('id', 'nav_name', 'title', 'slug', 'location', 'is_published')
            ->where('is_published', true)
            ->where('location', '=', 'footer_info')
            ->with(['gallery' => function ($query) {
                $query->select('id', 'page_id', 'path');
            }])
            ->get();

        return $pages;
    }

    public function getShowPage($id)
    {
        $page = $this->startConditions()
            ->select('id', 'title', 'slug', 'nav_name', 'description', 'is_published')
            ->where('id', $id)
            ->with('gallery:id,page_id,path')
            ->first();

        return $page;
    }

    public function getIdPageFromSlug($slug) {
        $id = $this->startConditions()
            ->select('id', 'slug')
            ->where('slug', $slug)
            ->pluck('id')
            ->first();

        return $id;
    }
}