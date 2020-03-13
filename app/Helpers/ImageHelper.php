<?php
namespace App\Helpers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{

    /*
     *  @param $img
     *  @param $model
     *  @param float $ratio
     *  @return string
     *
     *  Save (crop) upload img file and return path to file
     *  ratio = 1.65 - category (default)
     */
    public function saveImgFile($img, $model, $ratio = 1.65)
    {
        $nameModel = mb_strtolower(substr(get_class($model), strripos(get_class($model), '\\') + 1));
        $uploadsDir = 'uploads/' . $nameModel . '_' . $model->id . '/img';
        $path = $uploadsDir . '/' . Str::random(15);
        Storage::disk('public')->makeDirectory($uploadsDir);

        $itemImgFull = Image::make($img);
        $itemImgCrop = clone $itemImgFull;
        $imgData = $itemImgCrop->exif();
        $imgWidth = $imgData['COMPUTED']['Width'];
        $imgHeight = $imgData['COMPUTED']['Height'];

        $imgRatio = round($imgWidth / $imgHeight, 2);

        $size = [
            'small' => 400,
            'medium' => 800
        ];

        do {
            if ($imgRatio < $ratio) {
                $imgHeightCrop = round($imgWidth / $ratio, 0);
                $itemImgCrop->crop($imgWidth, $imgHeightCrop, 0, round(($imgHeight - $imgHeightCrop) / 2, 0));
            } elseif ($imgRatio > $ratio) {
                $imgWidthCrop = round($imgHeight * $ratio, 0);
                $itemImgCrop->crop($imgWidthCrop, $imgHeight, round(($imgWidth - $imgWidthCrop) / 2, 0), 0);
            }

            foreach ($size as $key => $item) {
                $itemImgCropSize = clone $itemImgCrop;
                $itemImgCropSize->resize($item, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $pathCrop = $path . '_' . $key;
                $itemImgCropSize->save(storage_path() . '/app/public/' . $pathCrop . '.jpg', 90);
            }

            if (key($size) == 'large') {
                break;
            }
            $itemImgCrop = clone $itemImgFull;
            $ratio = 3.5;
            $size = ['large' => 1800];
        } while ($nameModel == 'category');

        return $path;
    }
}
