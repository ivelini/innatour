<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsRepository
{
    public function getTourSearchForm()
    {
        $data = DB::table('settings')
            ->where('name', '=', 'tourSearchForm')
            ->pluck('text')
            ->first();

        return $data;
    }

    public function getSettingsData()
    {
        $dataDB = DB::table('settings')
            ->select('name', 'text')
            ->where('name', '=', 'siteName')
            ->orWhere('name', '=', 'siteDescription')
            ->orWhere('name', '=', 'siteAddress')
            ->orWhere('name', '=', 'sitePhones')
            ->orWhere('name', '=', 'siteClockWork')
            ->orWhere('name', '=', 'siteVk')
            ->orWhere('name', '=', 'siteOk')
            ->orWhere('name', '=', 'siteFb')
            ->orWhere('name', '=', 'siteInsta')
            ->get();

        foreach ($dataDB as $item) {
            $data[$item->name] = $item->text;
        }

        if(empty($data)) {
            $data = null;
        }
        return $data;
    }
}
