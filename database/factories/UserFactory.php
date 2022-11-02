<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'sex' => rand(0, 1),
            'city_code' => rand(1, 5),
            'city_name' => fake()->city(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => Hash::make('12345678'), // password
            'balance' => rand(1, 5000) * 100,
            'photo_path' => $this->faker->fixturesImage('avatars', '/images/avatars'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
