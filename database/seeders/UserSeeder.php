<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Agil Yaiz',
                'email' => 'agil@gmail.com',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@gmail.com',
                'role' => 'Admin',
            ],

            [
                'name' => 'Budi Penyewa',
                'email' => 'tenant@gmail.com',
                'role' => 'Tenant',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]);
        }
    }
}
