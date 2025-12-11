<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\GeoService;

class DetectCurrencyMiddleware
{
    public function handle($request, Closure $next)
    {
        $geo = new GeoService();
        $data = $geo->getCurrencyData();

        view()->share('user_currency_symbol', $data['symbol']);
        view()->share('user_currency_rate_to_npr', $data['rate_to_npr']);
        view()->share('user_country', $data['country']);

        return $next($request);
    }
}