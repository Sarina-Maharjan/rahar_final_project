<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Observers\PostObserver;
use App\Observers\BannerObserver;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Product::observe(ProductObserver::class);
        Post::observe(PostObserver::class);
        Banner::observe(BannerObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
