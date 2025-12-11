<?php
namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ImageResizeService {
    public static function createSizes(string $originalPath, string $filename, string $baseDir) {
        $img = Image::make($originalPath);
        if ($img->width() > $img->height()) {
            $sizes = [
                '300X200' => ['width' => 300, 'height' => 200],
                '900X600' => ['width' => 900, 'height' => 600],
                '1200X800' => ['width' => 1200, 'height' => 800],
            ];
        }else if ($img->height() > $img->width()) {
            $sizes = [
                '200X300' => ['width' => 200, 'height' => 300],
                '600X900' => ['width' => 600, 'height' => 900],
                '800X1200' => ['width' => 800, 'height' => 1200],
            ];
        }else {
            $sizes = [
                '300X300' => ['width' => 300, 'height' => 300],
                '600X600' => ['width' => 600, 'height' => 600],
                '800X800' => ['width' => 800, 'height' => 800],
            ];
        }

        foreach ($sizes as $folder => $dim) {
            $imageCopy = Image::make($originalPath);
            $sizeDir = $baseDir . DIRECTORY_SEPARATOR . $folder;
            $targetPath = $sizeDir . DIRECTORY_SEPARATOR . $filename;

            //skip if already cropped
            if (File::exists($targetPath)) {
                continue;
            }

            // Create folder if not exists
            if (!File::exists($sizeDir)) {
                File::makeDirectory($sizeDir, 0755, true);
            }


            // Open and crop image
            $img = Image::make($originalPath)
                        ->fit($dim['width'], $dim['height'], function ($constraint) {
                            $constraint->aspectRatio(); // preserve ratio
                            $constraint->upsize(); // prevent stretching
                        });
                        // ->resizeCanvas($dim['width'], $dim['height'], 'center', false, '#ffffff'); // pad to target size

            $img->save($targetPath, 90);
        }
    }
}
