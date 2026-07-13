<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = \App\Models\Property::all();

        if ($properties->count() > 0) {
            foreach (range(1, 5) as $i) {
                \App\Models\Room::create([
                    'property_id' => $properties->random()->id,
                    'room_number' => 'A' . rand(10, 99),
                    'price_per_month' => rand(5, 15) * 100000, // 500k to 1.5M
                    'status' => collect(['Available', 'Occupied', 'Maintenance'])->random(),
                ]);
            }
        }
    }
}
