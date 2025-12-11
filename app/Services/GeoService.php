<?php
namespace App\Services;

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;
use App\Models\Country;
use App\Models\CurrencyRate;

class GeoService
{
    protected $ip;
    protected $defaultCurrency = 'NPR';

    public function __construct()
    {
        $this->ip = request()->ip();

        // For local development
        if ($this->ip === '127.0.0.1') {
            $this->ip = '77.111.247.77'; // Nepal IP for testing
        }
    }

    public function getCurrencyData()
    {
        $cacheKey = 'currency_data_' . $this->ip;

        return Cache::remember($cacheKey, now()->addHours(6), function () {
            $location = Location::get($this->ip);
            $countryName = $location?->countryName ?? null;

            if (!$countryName) {
                return $this->defaultData();
            }

            $country = Country::where('name', $countryName)->first();
            
            $symbol = $country->currency_symbol ?? "Rs";
            $code  =  $country->currency_symbol ?? "NRP";

            $rate = CurrencyRate::where('currency_symbol', $code)->value('rate_to_npr') ?? 1;

            return [
                'symbol' => $symbol,
                'rate_to_npr' => $rate,
                'country' => $countryName,
            ];
        });
    }

    protected function defaultData()
    {
        return [
            'symbol' => $this->defaultCurrency,
            'rate_to_npr' => 1,
            'country' => 'Nepal',
        ];
    }
}

