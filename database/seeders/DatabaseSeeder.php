<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BalanceTransfer;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        Event::factory(20)->create();
        Order::factory(50)->create();
        Feedback::factory(10)->create();
        BalanceTransfer::factory(50)->create();
    }
}
