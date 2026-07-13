<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada booking dengan status Completed
        $completedBookings = \App\Models\Booking::where('status', 'Completed')->get();
        
        if ($completedBookings->count() < 2) {
            $bookingsToUpdate = \App\Models\Booking::where('status', '!=', 'Completed')->take(2 - $completedBookings->count())->get();
            foreach ($bookingsToUpdate as $booking) {
                $booking->update(['status' => 'Completed']);
            }
            $completedBookings = \App\Models\Booking::where('status', 'Completed')->get();
        }

        foreach ($completedBookings->take(2) as $booking) {
            \App\Models\Review::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'rating' => rand(4, 5),
                'comment' => 'Kos ini sangat nyaman dan bersih. Fasilitas lengkap dan ibu kosnya ramah.',
            ]);
        }
    }
}
