<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Office Supplies', 'description' => 'Paper, pens, stationery', 'color' => '#3B82F6'],
            ['name' => 'Rent', 'description' => 'Office rent and utilities', 'color' => '#EF4444'],
            ['name' => 'Utilities', 'description' => 'Electricity, water, internet', 'color' => '#F59E0B'],
            ['name' => 'Transport', 'description' => 'Fuel, taxi, transport costs', 'color' => '#10B981'],
            ['name' => 'Salaries', 'description' => 'Employee wages and benefits', 'color' => '#8B5CF6'],
            ['name' => 'Marketing', 'description' => 'Advertising and promotions', 'color' => '#EC4899'],
            ['name' => 'Communication', 'description' => 'Phone, airtime, data', 'color' => '#06B6D4'],
            ['name' => 'Maintenance', 'description' => 'Repairs and maintenance', 'color' => '#84CC16'],
            ['name' => 'Bank Charges', 'description' => 'Bank fees and charges', 'color' => '#6366F1'],
            ['name' => 'Miscellaneous', 'description' => 'Other expenses', 'color' => '#6B7280'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
