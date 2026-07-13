<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = \App\Models\Booking::all();

        if ($bookings->count() > 0) {
            foreach (range(1, 3) as $i) {
                $booking = $bookings->random();
                \App\Models\Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_price,
                    'payment_date' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                    'proof_of_payment' => null, // default dummy has no proof image
                    'status' => collect(['Pending', 'Verified', 'Rejected'])->random(),
                ]);
            }
        }
    }
}
