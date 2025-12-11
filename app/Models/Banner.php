<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->photo) {
                $photoPath = ltrim(str_replace('/storage/', '', $model->photo), '/');

                if (Storage::disk('public')->exists($photoPath)) {
                    try {
                        $fullPath = Storage::disk('public')->path($photoPath);
                        $image = Image::make($fullPath);

                        $model->image_width = $image->width();
                        $model->image_height = $image->height();
                    } catch (\Exception $e) {
                        // You can log the error if needed
                        // Log::warning("Image read failed: " . $e->getMessage());
                    }
                }
            }
        });
    }
    protected $fillable=['title','slug','description','photo','status'];
}
