<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'phone_numbers' => json_encode([$this->faker->phoneNumber, $this->faker->phoneNumber]), // Multiple phone numbers
            'referral_source' => $this->faker->randomElement(['Google', 'Friend', 'Social Media', 'Advertisement']),
            'location' => json_encode([
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude
            ]),
            'technology_interests' => json_encode($this->faker->randomElements(['PHP', 'Laravel', 'VueJs', 'MySQL', 'CodeIgniter'], rand(1, 3))),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
