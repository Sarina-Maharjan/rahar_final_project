<?php

namespace App\Observers;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class CountryObserver
{
    /**
     * Handle the Country "created" event.
     */
    public function created(Country $country): void
    {
        //
        Cache::store('redis')->forget("country_listing");
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $country): void
    {
        //
        Cache::store('redis')->forget("country_listing");
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $country): void
    {
        //
        Cache::store('redis')->forget("country_listing");
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $country): void
    {
        //
        Cache::store('redis')->forget("country_listing");
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $country): void
    {
        //
        Cache::store('redis')->forget("country_listing");
    }
}
