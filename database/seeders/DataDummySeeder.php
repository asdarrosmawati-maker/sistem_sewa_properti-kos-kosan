<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Facility;
use App\Models\Review;
use App\Models\Expense;
use App\Models\MaintenanceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DataDummySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'Superadmin')->first() ?? User::first();
        
        // Buat 5 Tenant baru
        $tenants = [];
        for ($i = 1; $i <= 5; $i++) {
            $tenants[] = User::firstOrCreate(
                ['email' => "tenant{$i}@example.com"],
                [
                    'name' => "Penyewa $i",
                    'password' => Hash::make('password'),
                    'role' => 'Tenant',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Buat 5 Properti
        $properties = [];
        for ($i = 1; $i <= 5; $i++) {
            $properties[] = Property::create([
                'user_id' => $admin->id,
                'name' => "Kos Eksklusif " . ['Anggrek', 'Matahari', 'Tulip', 'Kamboja', 'Kenanga'][$i-1],
                'address' => "Jl. Bunga No. 10$i, Kota Indah",
                'description' => "Fasilitas lengkap, aman dan nyaman untuk ditinggali. Tersedia parkir luas.",
            ]);
            
            // Buat 5 Fasilitas untuk setiap properti
            for ($f = 1; $f <= 5; $f++) {
                Facility::create([
                    'property_id' => $properties[$i-1]->id,
                    'name' => ['WiFi 100Mbps', 'AC', 'Kamar Mandi Dalam', 'Dapur Bersama', 'Parkir Motor'][$f-1],
                    'description' => 'Fasilitas standar kami.',
                ]);
            }
            
            // Buat 1 Pengeluaran per properti
            Expense::create([
                'property_id' => $properties[$i-1]->id,
                'amount' => 150000 * $i,
                'expense_date' => Carbon::now()->subDays($i),
                'description' => 'Pembayaran tagihan listrik dan air bulan ini.',
            ]);
        }

        // Buat 5 Kamar
        $rooms = [];
        for ($i = 1; $i <= 5; $i++) {
            $rooms[] = Room::create([
                'property_id' => $properties[$i-1]->id,
                'room_number' => "A-10$i",
                'price_per_month' => 1000000 + ($i * 100000),
                'status' => 'Occupied'
            ]);
        }

        // Buat 5 Penyewaan (Booking)
        $bookings = [];
        for ($i = 1; $i <= 5; $i++) {
            $isCompleted = $i % 2 == 0;
            $status = $isCompleted ? 'Completed' : 'Active';
            
            $bookings[] = Booking::create([
                'user_id' => $tenants[$i-1]->id,
                'room_id' => $rooms[$i-1]->id,
                'start_date' => Carbon::now()->subMonths($i)->toDateString(),
                'end_date' => $isCompleted ? Carbon::now()->subDays($i)->toDateString() : Carbon::now()->addMonths(6)->toDateString(),
                'total_price' => $rooms[$i-1]->price_per_month * ($isCompleted ? $i : 6),
                'status' => $status
            ]);
        }

        // Buat 5 Pembayaran
        foreach ($bookings as $index => $booking) {
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price / 2, // Bayar DP atau setengah
                'payment_date' => Carbon::now()->subDays(5 - $index)->toDateString(),
                'status' => 'Verified'
            ]);
        }

        // Buat 5 Pemeliharaan (Maintenance Request)
        foreach ($bookings as $index => $booking) {
            if ($booking->status == 'Active') {
                MaintenanceRequest::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'issue_description' => "Kerusakan pada fasilitas di kamar, mohon segera dicek.",
                    'status' => ['Pending', 'In Progress', 'Resolved'][$index % 3]
                ]);
            }
        }

        // Buat 5 Ulasan (Review) dari Booking yang Completed
        foreach ($bookings as $index => $booking) {
            if ($booking->status == 'Completed') {
                Review::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'rating' => 4 + ($index % 2), // Rating 4 atau 5
                    'comment' => "Pengalaman ngekos yang sangat menyenangkan. Fasilitasnya bagus dan bersih."
                ]);
            }
        }
    }
}
