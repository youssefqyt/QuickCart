<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'address' => fake()->address(),
            'total' => fake()->randomFloat(2, 20, 1000),
            'status' => 'pending',
            'payment_status' => 'pending',
            'stripe_session_id' => null,
            'stripe_payment_intent_id' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'payment_status' => 'paid',
            'status' => 'processing',
            'stripe_session_id' => 'cs_test_' . fake()->uuid(),
        ]);
    }
}
