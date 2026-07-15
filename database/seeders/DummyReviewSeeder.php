<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\Booking;

class DummyReviewSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = User::where('role', 'Tenant')->first();
        $admin = User::where('role', 'Superadmin')->first();

        if (!$tenant || !$admin) {
            echo "Users not found";
            return;
        }

        $property = Property::create([
            'user_id' => $admin->id,
            'name' => 'Kos Melati Harum',
            'address' => 'Jl. Melati No. 456',
            'description' => 'Kos elit harga irit'
        ]);

        $room = Room::create([
            'property_id' => $property->id,
            'room_number' => 'VIP-1',
            'price_per_month' => 2000000,
            'status' => 'Available'
        ]);

        $booking = Booking::create([
            'user_id' => $tenant->id,
            'room_id' => $room->id,
            'start_date' => now()->subMonths(6)->toDateString(),
            'end_date' => now()->subDays(1)->toDateString(),
            'total_price' => 2000000 * 6,
            'status' => 'Completed'
        ]);
        
        echo "Data dummy khusus untuk Ulasan (Booking Selesai) berhasil ditambahkan!";
    }
}
