<?php

namespace App\Observers;

use App\Models\Product;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
        Cache::store('redis')->forget("product_listing");
        Cache::store('redis')->forget("product_listing_featured");
        Cache::store('redis')->forget("product_listing_recent");
        $this->clearProductListingCache();
        
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
        Cache::store('redis')->forget("product_detail_{$product->slug}");
        Cache::store('redis')->forget("product_listing");
        Cache::store('redis')->forget("product_listing_featured");
        Cache::store('redis')->forget("product_listing_recent");
        $this->clearProductListingCache();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
        Cache::store('redis')->forget("product_detail_{$product->slug}");
        Cache::store('redis')->forget("product_listing");
        Cache::store('redis')->forget("product_listing_featured");
        Cache::store('redis')->forget("product_listing_recent");
        $this->clearProductListingCache();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
        Cache::store('redis')->forget("product_detail_{$product->slug}");
        Cache::store('redis')->forget("product_listing");
        Cache::store('redis')->forget("product_listing_featured");
        Cache::store('redis')->forget("product_listing_recent");
        $this->clearProductListingCache();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
        Cache::store('redis')->forget("product_detail_{$product->slug}");
        Cache::store('redis')->forget("product_listing");
        Cache::store('redis')->forget("product_listing_featured");
        Cache::store('redis')->forget("product_listing_recent");
        $this->clearProductListingCache();
    }

    public function clearProductListingCache(): void
    {
        $client = Redis::connection()->client();
        $redis = Cache::store('redis')->getRedis();
        $cursor = 0;
        $prefix = config('database.redis.options.prefix') ?? '';

        $match = $prefix  .'product_listing_*';
        // dd($keys);
        do {
            [$cursor, $keys] = $client->scan($cursor, 'MATCH', $match, 'COUNT', 100);
            // dd($keys);
            foreach ($keys as $key) {
                if (str_starts_with($key, $prefix)) {
                    $unprefixedKey = substr($key, strlen($prefix));
                    Cache::store('redis')->forget($unprefixedKey);
                }
            }
        } while ($cursor != 0);

   
    }
}
