<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'creator_id' => User::inRandomOrder()->first(),
            'starts_at' => now()->addDays(1)->addHours(rand(1, 5))->addMinutes(rand(1, 30)),
            'ends_at' => now()->addDays(2)->addHours(rand(1, 5))->addMinutes(rand(1, 30)),
            'price' => rand(100, 2000),
            'city' => rand(1, 5),
            'city_name' => fake()->city(),
            'street' => fake()->streetName(),
            'building' => fake()->buildingNumber(),
            'phone' => fake()->phoneNumber(),
            'description' => $this->faker->text(200),
            'max_members' => rand(2, 5),
        ];
    }
}
