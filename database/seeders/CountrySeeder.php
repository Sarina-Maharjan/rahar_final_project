<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = storage_path('data/countries.json');

        // Ensure the data directory exists
        if (!is_dir(storage_path('data'))) {
            mkdir(storage_path('data'), 0755, true);
        }

        // Updated API with only needed fields
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,cca2,idd,currencies,postalCode');

        if ($response->successful()) {
            $countriesRaw = $response->json();
            $filtered = [];

            foreach ($countriesRaw as $country) {
                if (
                    empty($country['name']['common']) ||
                    empty($country['cca2']) ||
                    empty($country['idd']['root']) ||
                    empty($country['currencies'])
                ) {
                    continue;
                }

                // Build phone code
                $phoneCode = $country['idd']['root'];
                if (!empty($country['idd']['suffixes'][0])) {
                    $phoneCode .= $country['idd']['suffixes'][0];
                }

                // Extract currency details
                $currencyCode = array_key_first($country['currencies']);
                $currencyData = $country['currencies'][$currencyCode] ?? [];
                $currencyName = $currencyData['name'] ?? null;
                $currencySymbol = $currencyData['symbol'] ?? null;

                $filtered[] = [
                    'name' => $country['name']['common'],
                    'iso2' => $country['cca2'],
                    'phone_code' => $phoneCode,
                    'zip_format' => $country['postalCode']['format'] ?? null,
                    'currency' => $currencyName,
                    'currency_code' => $currencyCode,
                    'currency_symbol' => $currencySymbol,
                ];
            }

            // Save to local JSON file
            file_put_contents($jsonPath, json_encode($filtered, JSON_PRETTY_PRINT));
        }

        // Seed into database
        if (file_exists($jsonPath)) {
            $countries = json_decode(file_get_contents($jsonPath), true);

            foreach ($countries as $c) {
                DB::table('countries')->insert($c);
            }
        }
    }
}
