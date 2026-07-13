<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\User::where('role', 'Tenant')->first();
        $rooms = \App\Models\Room::all();

        if ($tenant && $rooms->count() > 0) {
            foreach (range(1, 5) as $i) {
                $status = collect(['Pending', 'Active', 'Completed'])->random();
                $room = $rooms->random();
                \App\Models\Booking::create([
                    'user_id' => $tenant->id,
                    'room_id' => $room->id,
                    'start_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                    'end_date' => now()->addDays(rand(31, 60))->format('Y-m-d'),
                    'total_price' => $room->price_per_month * rand(1, 3),
                    'status' => $status,
                ]);

                if ($status == 'Active') {
                    $room->update(['status' => 'Occupied']);
                }
            }
        }
    }
}
