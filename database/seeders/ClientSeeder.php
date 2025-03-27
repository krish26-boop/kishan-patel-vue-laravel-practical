<?php

namespace Database\Seeders;

use App\Models\Technology;
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
        // for ($i = 1; $i <= 100; $i++) {
        //     User::create([
        //         'first_name' => 'Client' . $i,
        //         'last_name' => 'User' . $i,
        //         'email' => 'client' . $i . '@example.com',
        //         'password' => 'password123',
        //         'phone_numbers' => '123456789' . $i,
        //         'referral_source' => ['LinkedIn', 'Facebook', 'Google', 'Friend', 'Website', 'Other'][rand(0, 5)],
        //         'location' => json_encode(['lat' => rand(-90, 90), 'lng' => rand(-180, 180)]),
        //     ]);
        // }

        $sources = ['LinkedIn', 'Facebook', 'Google', 'Friend', 'Website', 'Other'];
        $technologies = Technology::all();
        
        User::factory(100)->create()->each(function ($client) use ($sources, $technologies) {
            // Set registration source
            $client->update(['referral_source' => $sources[array_rand($sources)]]);
            
            // Add phones
            $client->phones()->create(['phone_number' => '1234567890']);
            
            // Add random technologies
            $client->technologies()->attach(
                $technologies->random(rand(1, 3))->pluck('id')->toArray()
            );
            
            // Add location
            $client->update(['location' => json_encode([
                'lat' => mt_rand(-90000000, 90000000) / 1000000,
                'lng' => mt_rand(-180000000, 180000000) / 1000000
            ])]);
        });
    }
}
