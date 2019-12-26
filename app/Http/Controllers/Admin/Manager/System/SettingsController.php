<?php

namespace App\Http\Controllers\Admin\Manager\System;

use App\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    protected $settingsRepository;

    public function __construct()
    {
        $this->settingsRepository = new SettingsRepository();
    }

    public function index()
    {
        $data = $this->settingsRepository->getSettingsData();
        return view('admin.page.manager.system.settings', compact('data'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        foreach ($inputs as $key => $value) {
                $key = ['name' => $key];
                $value = ['text' => $value];
                DB::table('settings')->updateOrInsert($key, $value);
        }

        return redirect()
            ->back()
            ->with(['success' => 'Настройки успешно сохранены']);
    }
}
