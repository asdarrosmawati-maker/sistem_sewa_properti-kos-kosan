<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = \App\Models\Property::all();

        foreach ($properties as $property) {
            foreach (range(1, 3) as $i) {
                \App\Models\Gallery::create([
                    'property_id' => $property->id,
                    'room_id' => null,
                    'image_path' => 'dummy/gallery_' . $i . '.jpg', // dummy path
                    'caption' => 'Foto Properti ' . $property->name . ' - Bagian ' . $i,
                ]);
            }
        }
    }
}
