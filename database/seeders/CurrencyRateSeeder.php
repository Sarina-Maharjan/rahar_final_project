<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\CurrencyRate;

class CurrencyRateSeeder extends Seeder
{
    protected $filePath = 'data/currencyrate/rates.json'; // relative to storage folder
    protected $apiUrl = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/npr.json';

    public function run(): void
    {
        $fullPath = storage_path($this->filePath); // full path to storage/data/currencyrate/rates.json

        // Create directory if not exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Fetch fresh rates from API
        $response = Http::get($this->apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            // Save to storage/data/currencyrate/rates.json
            file_put_contents($fullPath, json_encode($data, JSON_PRETTY_PRINT));

            $this->updateDatabase($data);
        } else {
            // Handle failure silently or log error
        }
    }

    protected function updateDatabase(array $data): void
    {
        $rates = $data['npr'] ?? [];

        foreach ($rates as $symbol => $rate) {
            CurrencyRate::updateOrCreate(
                ['currency_symbol' => $symbol],
                ['rate_to_npr' => 1 / $rate]
            );
        }
    }
}
