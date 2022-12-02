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
            'fee' => rand(1, 100),
            'city_fias_id' => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5', //Moscow,
            'utc_offset' => 3,
            'city_name' => 'Москва',
            'street_fias_id' => 'null',
            'street' => fake()->streetName(),
            'building_fias_id' => 'null',
            'building' => fake()->buildingNumber(),
            'phone' => fake()->phoneNumber(),
            'description' => $this->faker->text(500),
            'max_members' => rand(2, 10),
        ];
    }
}
