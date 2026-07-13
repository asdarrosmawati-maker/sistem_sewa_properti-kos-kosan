<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = \App\Models\Property::all();

        foreach ($properties as $property) {
            \App\Models\Expense::create([
                'property_id' => $property->id,
                'description' => 'Pembayaran tagihan listrik PLN bulan ini',
                'amount' => 500000,
                'expense_date' => \Carbon\Carbon::now()->subDays(5),
            ]);

            \App\Models\Expense::create([
                'property_id' => $property->id,
                'description' => 'Biaya perbaikan kran air dan pipa',
                'amount' => 150000,
                'expense_date' => \Carbon\Carbon::now()->subDays(2),
            ]);

            \App\Models\Expense::create([
                'property_id' => $property->id,
                'description' => 'Gaji penjaga / kebersihan kos',
                'amount' => 1200000,
                'expense_date' => \Carbon\Carbon::now()->subDays(1),
            ]);
        }
    }
}
