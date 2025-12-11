<?php 

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class RedisCacheService
{
    public function remember($key, $ttl, \Closure $callback)
    {
       
        return Cache::store('redis')->remember($key, $ttl, $callback);
    }

    public function forget($key)
    {
        return Cache::store('redis')->forget($key);
    }
}