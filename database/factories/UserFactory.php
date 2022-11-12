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
        $sex = fake()->randomElement(['male', 'female']);

        return [
            'first_name' => fake()->firstName($sex),
            'last_name' => fake()->lastName($sex),
            'sex' => $sex,
            'city_fias_id' => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5', //Moscow
            'city_name' => 'Москва',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => Hash::make('12345678'),
            'balance' => rand(1, 5000),
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
