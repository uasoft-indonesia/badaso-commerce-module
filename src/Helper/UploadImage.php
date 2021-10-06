<?php

namespace Uasoft\Badaso\Module\Commerce\Helper;

use Exception;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;

class UploadImage
{
    public static function createImage($base64, $path = "")
    {
        try {
            $image_parts = explode(";base64,", $base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = config('lfm.folder_categories.file.folder_name') . '/' . auth()->user()->id . '/' . $path . uniqid(Uuid::uuid(), true) . '.' . $image_type;

            Storage::put($file, $image_base64);

            return $file;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function deleteImage($file)
    {
        try {
            Storage::delete($file);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}