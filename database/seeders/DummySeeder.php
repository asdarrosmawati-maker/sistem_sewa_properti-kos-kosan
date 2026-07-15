<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\Booking;

class DummySeeder extends Seeder
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
            'name' => 'Kos Mawar Mekar',
            'address' => 'Jl. Mawar No. 123',
            'description' => 'Kos nyaman dan aman'
        ]);

        $room = Room::create([
            'property_id' => $property->id,
            'room_number' => '101',
            'price_per_month' => 1500000,
            'status' => 'Occupied'
        ]);

        $booking = Booking::create([
            'user_id' => $tenant->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonths(6)->toDateString(),
            'total_price' => 1500000 * 6,
            'status' => 'Active'
        ]);
        
        echo "Data dummy (Properti, Kamar, Booking) berhasil ditambahkan!";
    }
}
