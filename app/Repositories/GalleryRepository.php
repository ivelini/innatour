<?php

namespace App\Repositories;

use App\Models\Gallery as Model;

class GalleryRepository extends CoreRepository
{
    public function getModelClass()
    {
      return Model::class;
    }

    public function getPathsPhotos (array $photosId):array {
        $paths = $this->startConditions()
            ->whereIn('id', $photosId)
            ->pluck('path')
            ->all();

        return $paths;
    }

    public function getEdit($id) {
        $gallery = $this->startConditions()
            ->select('id', 'tour_id', 'category_id', 'page_id', 'path', 'is_header')
            ->where('id', $id)
            ->first();

        return $gallery;
    }
}
