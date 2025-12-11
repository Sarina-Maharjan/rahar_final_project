<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
        Cache::store('redis')->forget("post_listing");
        $this->clearPostListingCache();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
        Cache::store('redis')->forget("post_detail_".$post->slug);
        Cache::store('redis')->forget("post_listing");
        $this->clearPostListingCache();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
        Cache::store('redis')->forget("post_detail_".$post->slug);
        Cache::store('redis')->forget("post_listing");
        $this->clearPostListingCache();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
        Cache::store('redis')->forget("post_detail_".$post->slug);
        Cache::store('redis')->forget("post_listing");
        $this->clearPostListingCache();
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
        Cache::store('redis')->forget("post_detail_".$post->slug);
        Cache::store('redis')->forget("post_listing");
        $this->clearPostListingCache();
    }

    public function clearPostListingCache(): void
    {
        $redis = Cache::store('redis')->getRedis();
        $client = Redis::connection()->client();
        $cursor = 0;
        $prefix = config('database.redis.options.prefix') ?? '';

        $match = $prefix  .'post_listing_*';
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
