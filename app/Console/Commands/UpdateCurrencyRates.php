<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\CurrencyRateSeeder;

class UpdateCurrencyRates extends Command
{
    protected $signature = 'currency:update-rates';
    protected $description = 'Fetch and update currency rates from API';

    public function handle()
    {
        $this->info('Starting currency rate update...');

        $seeder = new CurrencyRateSeeder();

        try {
            $seeder->run();
            $this->info('Currency rates updated successfully.');
        } catch (\Exception $e) {
            $this->error('Error updating currency rates: ' . $e->getMessage());
        }

        return 0;
    }
}
