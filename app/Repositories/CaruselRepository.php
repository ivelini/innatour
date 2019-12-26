<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CaruselRepository
{
    public function getCaruselItems() {
        $items = DB::table('carusel')
            ->select('title', 'description', 'path', 'link')
            ->get();

        return $items;
    }
}
