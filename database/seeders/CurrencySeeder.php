<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate' => 1,
                'is_base' => true,
                'is_active' => true,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 0.92,
                'is_base' => false,
                'is_active' => true,
            ],
            [
                'code' => 'BIF',
                'name' => 'Burundian Franc',
                'symbol' => 'FBu',
                'exchange_rate' => 2850,
                'is_base' => false,
                'is_active' => true,
            ],
            [
                'code' => 'KES',
                'name' => 'Kenyan Shilling',
                'symbol' => 'KSh',
                'exchange_rate' => 153,
                'is_base' => false,
                'is_active' => true,
            ],
            [
                'code' => 'RWF',
                'name' => 'Rwandan Franc',
                'symbol' => 'FRw',
                'exchange_rate' => 1250,
                'is_base' => false,
                'is_active' => true,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
