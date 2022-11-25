<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transactions>
 */
class TransactionsFactory extends Factory
{
    public function definition()
    {
        $type = Arr::random(['refund', 'payment', 'withdrawal', 'refill']);
        $order_id = ($type === 'refund' || $type === 'payment') ? Order::inRandomOrder()->first() : null;

        return [
            'user_id' => User::inRandomOrder()->first(),
            'order_id' => $order_id,
            'type' => $type,
            'sum' => random_int(0, 2000),
            'description' => fake()->text(20),
        ];
    }
}
