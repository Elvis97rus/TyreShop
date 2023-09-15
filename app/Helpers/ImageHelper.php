<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImageHelper
{
    public static function saveTyreImage($tyre)
    {
        if (!file_get_contents($tyre->img_big_my) || !file_get_contents($tyre->img_small) || !file_get_contents($tyre->img_big_pish)){
            return Storage::url('public/images/tyres/no_tyre.jpg');
        }else{
            $image = file_get_contents($tyre->img_big_my) ?? file_get_contents($tyre->img_big_pish) ?? file_get_contents($tyre->img_small);
            $img_name_path = str_replace([' ', '/', '*'], '_', $tyre->name);

            $name = substr($tyre->img_big_my, strrpos($tyre->img_big_my, '/') + 1);

            $path = 'public/images/tyres/'. $tyre->marka.'/'.$img_name_path.'/1.jpg';
            Storage::put($path, $image);
            return Storage::url($path);
        }
    }
}
