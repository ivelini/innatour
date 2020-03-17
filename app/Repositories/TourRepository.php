<?php

namespace App\Repositories;

use App\Models\Tour as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourRepository extends CoreRepository
{
    protected $tourCalendarRepository;

    public function __construct()
    {
        parent::__construct();
        $this->tourCalendarRepository = new TourCalendarRepository();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function isIdenticalTitle($title, $id = false)
    {
        $slugs = DB::table('tours')->pluck('slug');
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

    public function getShowTour($id)
    {

        $tour = $this->startConditions()
            ->select('id', 'title', 'slug', 'description', 'is_published', 'price', 'sale', 'file_path', 'file_name')
            ->where('id', $id)
            ->with('categories:id,title,slug', 'gallery:id,tour_id,path,is_header')
            ->get();

        $tour = $tour->map(function ($item) {
            $item->head_description = Str::limit(strip_tags($item->description), 200);
            return $item;
        })
            ->first();

        return $tour;
    }

    public function getSelectCategories($tour)
    {
        $categories = $tour->categories()
            ->select('id', 'title', 'slug', 'description')
            ->get();

        return $categories;
    }

    public function getCurrentIdHeaderPhoto($tour)
    {
        $idHeaderPhoto = $tour->gallery
            ->first(function($item) {
                if ($item->is_header == 'true') {
                    return true;
                }
            });

        if (!empty($idHeaderPhoto)) {
            $idHeaderPhoto = $idHeaderPhoto->id;
        }

        return $idHeaderPhoto;
    }

    public function getAllPhotos($tour, $size)
    {
        $photos = $tour->gallery()
            ->select('id', 'tour_id', 'path', 'is_header')
            ->orderBy('id', 'ASC')
            ->get();

        $photos->map(function ($item) use ($size) {
            $path = $item->path;
            $item->path = substr($path, 0, stripos($path, '.')) . '_' . $size . '.jpg';
            return $item;
        });

        return $photos;
    }

    public function getUser($tour)
    {
        $user = $tour->user()
            ->select('id', 'name', 'email')
            ->get()
            ->first();

        return $user;
    }

    public function getAllTours()
    {
        $tours = $this->startConditions()
            ->select('id', 'title', 'price', 'sale', 'scope_id', 'is_published')
            ->with([
                'categories' => function ($query) {
                    $query->select('id', 'title');
                },
                'gallery' => function ($query) {
                    $query->select('id', 'tour_id', 'path', 'is_header')
                        ->where('is_header', true);
                },
                'scope' => function ($query) {
                    $query->select('id', 'title');
                }])
            ->get();

        $tours = $this->getPathSizeImgForTours($tours, 'small');

        return $tours;
    }

    public function getToursForIndexPage()
    {
        $tours = $this->startConditions()
            ->select('id', 'title', 'slug', 'is_published', 'price', 'sale')
            ->orderBy('id', 'DESC')
            ->where('is_published', true)
            ->with([
                'categories' => function ($query) {
                    $query->select('id', 'title');
                },
                'gallery' => function ($query) {
                    $query->select('id', 'tour_id', 'path', 'is_header')
                        ->where('is_header', true);
                }])
            ->limit(8)
            ->get();

        return $tours;
    }

    public function getToursForCalendarTableIndexPage()
    {
        $calendar = $this->tourCalendarRepository->getCalendarForIndexPage();

        return $calendar;
    }

    public function getCalendarTableForTour($id)
    {
        $calendar = $this->tourCalendarRepository->getCalendarForTour($id);

        return $calendar;
    }

    public function getToursWithSentMessages($tours_id)
    {
        $tours = $this->startConditions()
            ->select('id', 'title')
            ->find($tours_id)
            ->toArray();

        return $tours;
    }

    public function getIdTourFromSlug($slug)
    {
        $id = $this->startConditions()
            ->select('id', 'slug')
            ->where('slug', $slug)
            ->pluck('id')
            ->first();

        return $id;
    }

    public function getPathSizeImgForTours($tours, $size)
    {
        $tours->map(function ($item) use ($size) {
            $path = $item->gallery->first()->path;
            $item->gallery->first()->path = substr($path, 0, strripos($path, '.jpg')) . '_' . $size . '.jpg';
            return $item;
        });

        return $tours;
    }

    public function getPathSizeImgesForTour($tour, $size)
    {
        $tour->gallery->map(function ($item) use ($size) {
            $path = $item->path;
            $item->path = substr($path, 0, stripos($path, '.')) . '_' . $size . '.jpg';
            return $item;
        });

        return $tour;
    }

    public function assignIs_headerPathImage($tour) {
        $is_header = $tour->gallery->first(function ($item) {
            if ($item->is_header) {
                return true;
            }
        });

        if (empty($is_header)) {
            $tour->gallery->first()->is_header = true;
        }

        return $tour;
    }
}