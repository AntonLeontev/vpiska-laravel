<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Support\Str;
use App\Models\BalanceTransfer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        User::factory()->createOne([
            'first_name' => 'Антон',
            'last_name' => fake()->lastName('male'),
            'sex' => 'male',
            'city_fias_id' => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5',
            'city_name' => 'Москва',
            'email' => 'aner-anton@yandex.ru',
            'email_verified_at' => fake()->dateTime(),
            'password' => Hash::make('12345678'),
            'balance' => rand(1, 5000),
            'remember_token' => Str::random(10),
        ]);
        Event::factory(20)->create();
        Event::factory()->createOne([
            'creator_id' => 6,
            'starts_at' => now()->addDays(1)->addHours(rand(1, 5))->addMinutes(rand(1, 30)),
            'ends_at' => now()->addDays(2)->addHours(rand(1, 5))->addMinutes(rand(1, 30)),
            'price' => rand(100, 2000),
            'fee' => rand(1, 100),
            'city_fias_id' => '0c5b2444-70a0-4932-980c-b4dc0d3f02b5', //Moscow,
            'city_name' => 'Москва',
            'street_fias_id' => 'null',
            'street' => fake()->streetName(),
            'building_fias_id' => 'null',
            'building' => fake()->buildingNumber(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text(500),
            'max_members' => rand(2, 10),
        ]);
        Order::factory(50)->create();
        Feedback::factory(10)->create();
        BalanceTransfer::factory(50)->create();
    }
}
