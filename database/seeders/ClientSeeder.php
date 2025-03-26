<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'first_name' => 'Client' . $i,
                'last_name' => 'User' . $i,
                'email' => 'client' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'phone_numbers' => '123456789' . $i,
                'referral_source' => ['LinkedIn', 'Facebook', 'Google', 'Friend', 'Website', 'Other'][rand(0, 5)],
                'location' => json_encode(['lat' => rand(-90, 90), 'lng' => rand(-180, 180)]),
            ]);
        }
    }
}
