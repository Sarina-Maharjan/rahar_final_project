<?php

namespace App\Http\View\Composers;

use App\Models\Country;
use Illuminate\View\View;
use App\Services\RedisCacheService;

class GlobalComposer
{
    public function compose(View $view)
    {
        $cache = app(RedisCacheService::class);
        $ttl = 60 * 60 * 24;
        $countries = $cache->remember('country_listing', $ttl, function () {
            return Country::orderBy('name')->get();
        });
        $view->with('countries', $countries);
    }
}
