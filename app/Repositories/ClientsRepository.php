<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ClientsRepository
{
    public function getCountStatusNew() {
        $count = DB::table('clients')
            ->select('status')
            ->where('status', '=', 'new')
            ->count();

        return $count;
    }

    public function getCountStatusActive() {
        $count = DB::table('clients')
            ->select('status')
            ->where('status', '=', 'active')
            ->count();

        return $count;
    }

    public function getCountStatusClosed() {
        $count = DB::table('clients')
            ->select('status')
            ->where('status', '=', 'closed')
            ->count();

        return $count;
    }
}
