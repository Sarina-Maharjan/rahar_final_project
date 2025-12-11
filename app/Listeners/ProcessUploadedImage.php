<?php

namespace App\Listeners;

use App\Services\ImageResizeService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;

class ProcessUploadedImage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ImageWasUploaded $event) {
        $originalPath = $event->path();
        $filename = basename($originalPath);
        $baseDir = dirname($originalPath);

        ImageResizeService::createSizes($originalPath, $filename, $baseDir);
    }
}
