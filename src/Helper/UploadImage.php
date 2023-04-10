<?php

namespace Uasoft\Badaso\Module\Commerce\Helper;

use Exception;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;

class UploadImage
{
    public static function createImage($base64, $path = '')
    {
        try {
            $file_parts = explode(';base64,', $base64);
            $file_type_aux = explode('/', $file_parts[0]);
            $file_type = $file_type_aux[0];
            $file_base64 = base64_decode($file_parts[0]);
            $file = config('lfm.folder_categories.image.folder_name').'/'.auth()->user()->id.'/'.$path.uniqid(Uuid::uuid(), true).'.'.$file_type;
            Storage::put($file, $file_base64);

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
