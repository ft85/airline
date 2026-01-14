<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = [
            ['name' => 'Ethiopian Airlines', 'code' => 'ET', 'commission_percentage' => 7.5],
            ['name' => 'Kenya Airways', 'code' => 'KQ', 'commission_percentage' => 5.0],
            ['name' => 'Rwanda Air', 'code' => 'WB', 'commission_percentage' => 6.0],
            ['name' => 'Brussels Airlines', 'code' => 'SN', 'commission_percentage' => 4.5],
            ['name' => 'Air Tanzania', 'code' => 'TC', 'commission_percentage' => 8.0],
            ['name' => 'Uganda Airlines', 'code' => 'UR', 'commission_percentage' => 7.0],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
