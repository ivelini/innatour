<?php

namespace App\Repositories;

use App\Models\Scope as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScopeRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAll()
    {
        $scopes = $this->startConditions()
            ->select('id', 'title', 'slug')
            ->with('tours:id,scope_id')
            ->get();

        return $scopes;
    }

    public function getSelectScope($tour)
    {
        $selectScope = $tour
            ->scope;

        return $selectScope;
    }

    public function isIdenticalTitle($title)
    {
        $slugs = DB::table('scopes')->pluck('slug');
        $currentSlug = Str::slug($title);

        if ($slugs->contains($currentSlug)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllPublishedTourCurrentScope($id)
    {
        $tours = $this->startConditions()
            ->select('id', 'title', 'slug')
            ->where('id', $id)
            ->with(['tours' => function ($query) {
                $query->select('id', 'title', 'slug', 'price', 'scope_id', 'is_published')
                    ->where('is_published', true);
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

    public function getIdAcopeFromSlug($slug) {
        $id = $this->startConditions()
            ->select('id', 'slug')
            ->where('slug', $slug)
            ->pluck('id')
            ->first();

        return $id;
    }

}
