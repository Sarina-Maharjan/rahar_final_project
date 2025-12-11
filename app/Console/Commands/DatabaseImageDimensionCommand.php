<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\User;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;

class DatabaseImageDimensionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract image dimensions and update respective records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $photoPath = ltrim(str_replace(config('app.url').'/storage/', '', $product->photo), '/');
            if (!$product->photo || !Storage::disk('public')->exists($photoPath)) {
                $this->warn("Image missing for product ID {$product->id}");
                continue;
            }

            try {
                $imageData = Storage::disk('public')->get($photoPath);
                $image = Image::make($imageData);
                $product->image_width = $image->width();
                $product->image_height = $image->height();
                $product->save();

                $this->info("Updated product ID {$product->id}");
            } catch (\Exception $e) {
                $this->error("Failed to process image for product ID {$product->id}: {$e->getMessage()}");
            }
        }
        $categories = Category::all();
        foreach ($categories as $category) {
            $photoPath = ltrim(str_replace(config('app.url').'/storage/', '', $category->photo), '/');
            if (!$category->photo || !Storage::disk('public')->exists($photoPath)) {
                $this->warn("Image missing for category ID {$category->id}");
                continue;
            }

            try {
                $imageData = Storage::disk('public')->get($photoPath);
                $image = Image::make($imageData);
                $category->image_width = $image->width();
                $category->image_height = $image->height();
                $category->save();

                $this->info("Updated category ID {$category->id}");
            } catch (\Exception $e) {
                $this->error("Failed to process image for category ID {$category->id}: {$e->getMessage()}");
            }
        }
        $banners = Banner::all();
        foreach ($banners as $banner) {
            $photoPath = ltrim(str_replace(config('app.url').'/storage/', '', $banner->photo), '/');
            if (!$banner->photo || !Storage::disk('public')->exists($photoPath)) {
                $this->warn("Image missing for banner ID {$banner->id}");
                continue;
            }

            try {
                $imageData = Storage::disk('public')->get($photoPath);
                $image = Image::make($imageData);
                $banner->image_width = $image->width();
                $banner->image_height = $image->height();
                $banner->save();

                $this->info("Updated banner ID {$banner->id}");
            } catch (\Exception $e) {
                $this->error("Failed to process image for banner ID {$banner->id}: {$e->getMessage()}");
            }
        }
        $posts = Post::all();
        foreach ($posts as $post) {
            $photoPath = ltrim(str_replace(config('app.url').'/storage/', '', $post->photo), '/');
            if (!$post->photo || !Storage::disk('public')->exists($photoPath)) {
                $this->warn("Image missing for post ID {$post->id}");
                continue;
            }

            try {
                $imageData = Storage::disk('public')->get($photoPath);
                $image = Image::make($imageData);
                $post->image_width = $image->width();
                $post->image_height = $image->height();
                $post->save();

                $this->info("Updated post ID {$post->id}");
            } catch (\Exception $e) {
                $this->error("Failed to process image for post ID {$post->id}: {$e->getMessage()}");
            }
        }
        $users = User::all();
        foreach ($users as $user) {
            $photoPath = ltrim(str_replace(config('app.url').'/storage/', '', $user->photo), '/');
            if (!$user->photo || !Storage::disk('public')->exists($photoPath)) {
                $this->warn("Image missing for user ID {$user->id}");
                continue;
            }

            try {
                $imageData = Storage::disk('public')->get($photoPath);
                $image = Image::make($imageData);
                $user->image_width = $image->width();
                $user->image_height = $image->height();
                $user->save();

                $this->info("Updated user ID {$user->id}");
            } catch (\Exception $e) {
                $this->error("Failed to process image for user ID {$user->id}: {$e->getMessage()}");
            }
        }
        $this->info('Image dimension extraction completed.');
    }
}
