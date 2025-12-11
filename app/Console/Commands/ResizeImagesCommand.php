<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Console\Command;

class ResizeImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:resize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and resize all images in storage/photos without duplication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceDir = storage_path('app/public/photos');
        $images = array_filter(File::allFiles($sourceDir), function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']); 
        });


        foreach ($images as $imageFile) {
            $path = $imageFile->getPathname();

            // Skip if it's already in thumbs folder or size folder (e.g., 300X300/)
            if (
                str_contains(strtolower($path), DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR) || 
                preg_match('#[\\\\/]\d+X\d+[\\\\/]#', $path)
            ) {
                $this->line("Skipped: $path");
                continue;
            }
            // Load original image
            try {
                $image = Image::make($path);
            } catch (\Exception $e) {
                $this->warn("Failed to open image: " . $path);
                continue;
            }

            $originalWidth = $image->width();
            $originalHeight = $image->height();

            // Determine orientation
            if ($originalWidth === $originalHeight) {
                $sizes = ['300X300', '600X600', '800X800'];
            } elseif ($originalWidth > $originalHeight) {
                $sizes = ['300X200', '900X600', '1200X800'];
            } else {
                $sizes = ['200X300', '600X900', '800X1200'];
            }

            $relativePath = pathinfo($path);
            $dirName = str_replace($sourceDir . DIRECTORY_SEPARATOR, '', $relativePath['dirname']);
            $fileName = $relativePath['basename'];

            foreach ($sizes as $size) {
                $imageCopy = Image::make($path);
                [$resizeW, $resizeH] = explode('X', $size);

                // Correctly build the resized directory and path
                $resizedDir = $sourceDir . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $size;
                $resizedPath = $resizedDir . DIRECTORY_SEPARATOR . $fileName;

                if (File::exists($resizedPath)) {
                    $this->line("Already exists: $path");
                    continue;
                }
                $this->line($path);

                if (!File::exists($resizedDir)) {
                    $this->info("Made directory");
                    File::makeDirectory($resizedDir, 0755, true); //creates directories and parent directories as per needed
                }

                // Resize and save
                $imageCopy->fit((int) $resizeW, (int) $resizeH, function ($constraint) {
                            $constraint->aspectRatio(); // preserve ratio
                            $constraint->upsize(); // prevent stretching
                        })->save($resizedPath, 90);
                $this->info("Saved: $size/$fileName");
            }
        }

        $this->info('All images processed.');
    }
}
