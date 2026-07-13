<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = \App\Models\Property::all();

        $facilityList = [
            ['name' => 'WiFi Gratis', 'icon' => 'bx bx-wifi', 'description' => 'Koneksi internet cepat 50Mbps.'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'bx bx-bath', 'description' => 'Kamar mandi dengan shower dan kloset duduk.'],
            ['name' => 'Dapur Bersama', 'icon' => 'bx bx-fridge', 'description' => 'Dapur yang dilengkapi kompor dan kulkas.'],
            ['name' => 'AC', 'icon' => 'bx bx-wind', 'description' => 'Pendingin ruangan.'],
            ['name' => 'Parkir Motor', 'icon' => 'bx bx-car', 'description' => 'Area parkir aman untuk kendaraan.'],
        ];

        foreach ($properties as $property) {
            $selectedFacilities = collect($facilityList)->random(3);

            foreach ($selectedFacilities as $facility) {
                \App\Models\Facility::create([
                    'property_id' => $property->id,
                    'name' => $facility['name'],
                    'icon' => $facility['icon'],
                    'description' => $facility['description'],
                ]);
            }
        }
    }
}
