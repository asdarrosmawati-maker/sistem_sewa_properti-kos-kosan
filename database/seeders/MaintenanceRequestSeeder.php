<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = \App\Models\Booking::all();

        if ($bookings->count() > 0) {
            $booking1 = $bookings->random();
            \App\Models\MaintenanceRequest::create([
                'booking_id' => $booking1->id,
                'user_id' => $booking1->user_id,
                'issue_description' => 'AC di kamar tidak dingin dan meneteskan air.',
                'status' => 'Pending',
            ]);

            $booking2 = $bookings->random();
            \App\Models\MaintenanceRequest::create([
                'booking_id' => $booking2->id,
                'user_id' => $booking2->user_id,
                'issue_description' => 'Kran air di kamar mandi rusak dan air terus mengalir.',
                'status' => 'Resolved',
            ]);
        }
    }
}
