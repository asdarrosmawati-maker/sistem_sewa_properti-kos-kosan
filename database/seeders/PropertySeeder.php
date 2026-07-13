<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = \App\Models\User::where('role', 'Owner')->first();

        if ($owner) {
            \App\Models\Property::create([
                'user_id' => $owner->id,
                'name' => 'Kos Mawar Indah',
                'description' => 'Kos khusus putri dengan fasilitas lengkap dan lokasi strategis.',
                'address' => 'Jl. Kenangan No. 12, Jakarta',
            ]);

            \App\Models\Property::create([
                'user_id' => $owner->id,
                'name' => 'Kos Melati',
                'description' => 'Kos putra bebas jam malam, dekat kampus.',
                'address' => 'Jl. Perjuangan No. 45, Bandung',
            ]);

            \App\Models\Property::create([
                'user_id' => $owner->id,
                'name' => 'Kos Flamboyan Camp',
                'description' => 'Kos campur eksklusif, aman dan nyaman.',
                'address' => 'Jl. Kebahagiaan No. 8, Surabaya',
            ]);
        }
    }
}
