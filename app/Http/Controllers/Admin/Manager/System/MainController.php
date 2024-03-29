<?php

namespace App\Http\Controllers\Admin\Manager\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaruselRequiest;
use App\Models\Gallery;
use App\Repositories\CaruselRepository;
use App\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MainController extends Controller
{
    protected $caruselRepository;
    protected $settingsRepository;

    public function __construct()
    {
        $this->caruselRepository = new CaruselRepository();
        $this->settingsRepository = new SettingsRepository();
    }

    public function index()
    {
        $caruselItems = $this->caruselRepository->getCaruselItems();
        $tourSearchForm = $this->settingsRepository->getTourSearchForm();

        return view('admin.page.manager.system.head', compact('caruselItems', 'tourSearchForm'));
    }

    public function updateCarusel(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $link = $request->input('link');
        $paths = $this->saveImgFile($request->file('photo'));

        if (empty($title)) {
            DB::table('carusel')->truncate();
        } else {
            for ($i = 0; $i < count($title); $i++) {
                $tblCaruselPath = DB::table('carusel')
                    ->where('id', $i + 1)
                    ->pluck('path')
                    ->first();
                $path = !empty($paths[$i]) ? $paths[$i] : '';

                $data[] = [
                    'title' => !empty($title[$i]) ? $title[$i] : '',
                    'description' => !empty($description[$i]) ? $description[$i] : '',
                    'link' => !empty($link[$i]) ? $link[$i] : '',
                    'path' => !empty($tblCaruselPath) == true && empty($paths[$i]) == true ? $tblCaruselPath : $path,
                ];
            }

            DB::table('carusel')->truncate();
            DB::table('carusel')->insert($data);
        }

        return redirect()
            ->route('manager.system.main')
            ->with(['success' => 'Карусель успешно сохранена']);
    }

    public function updateTourSearch(Request $request)
    {
        $data = $request->input('tourSearchForm');

        if(!empty($data)) {
            $form = DB::table('settings')
                ->updateOrInsert(
                    ['name' => 'tourSearchForm'],
                    ['text' => $data]
                );
        }
        else {
            DB::table('settings')
                ->where('name', '=', 'tourSearchForm')
                ->delete();
        }

        return redirect()
            ->back()
            ->with(['success' => 'Поле "Поиск туров" обновлено']);
    }

    protected function saveImgFile($img)
    {

        $uploadsDir = 'uploads/carusel/img';
        Storage::disk('public')->makeDirectory($uploadsDir);

        $i = 0;
        $j = 0;
        $flag = true;
        $ratio = 3.4;
        while ($flag == true) {
            if (!empty($img[$i])) {
                $path = $uploadsDir . '/' . Str::random(15);

                $itemImg = Image::make($img[$i]);
                $imgData = $itemImg->exif();
                $imgWidth = $imgData['COMPUTED']['Width'];
                $imgHeight = $imgData['COMPUTED']['Height'];

                $imgRatio = round($imgWidth / $imgHeight, 2);

                if ($imgRatio < $ratio) {
                    $imgHeightCrop = round($imgWidth / $ratio, 0);
                    $itemImg->crop($imgWidth, $imgHeightCrop, 0, round(($imgHeight - $imgHeightCrop) / 2, 0));
                } elseif ($imgRatio > $ratio) {
                    $imgWidthCrop = round($imgHeight * $ratio, 0);
                    $itemImg->crop($imgWidthCrop, $imgHeight, round(($imgWidth - $imgWidthCrop) / 2, 0), 0);
                }

                $itemImg->resize(1800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $itemImg->save(storage_path() . '/app/public/' . $path . '.jpg', 90);
                $paths[$i] = $path . '.jpg';

                $i++;
            } else {
                $j++;
                $i++;
            }
            if ($j > 8) {
                $flag = false;
            }
        }
        if (empty($paths)) {
            $paths = null;
        }

        return $paths;
    }
}