<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_order_tracking_page(): void
    {
        $response = $this->get(route('orders.track'));
        $response->assertStatus(200);
        $response->assertSee('Track Your Order');
    }

    public function test_can_track_order_with_valid_id_and_email(): void
    {
        $order = Order::factory()->create([
            'customer_name' => 'John Tracker',
            'customer_email' => 'tracker@example.com',
            'status' => 'shipped',
            'total' => 89.99,
        ]);

        $product = Product::factory()->create(['name' => 'GPS Tracker']);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 89.99,
        ]);

        $response = $this->get(route('orders.track', [
            'order_id' => $order->id,
            'email' => 'tracker@example.com',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Order #' . $order->id);
        $response->assertSee('John Tracker');
        $response->assertSee('GPS Tracker');
        $response->assertSee('Shipped');
    }

    public function test_cannot_view_order_with_wrong_email(): void
    {
        $order = Order::factory()->create([
            'customer_email' => 'correct@example.com',
        ]);

        $response = $this->get(route('orders.track', [
            'order_id' => $order->id,
            'email' => 'wrong@example.com',
        ]));

        $response->assertStatus(200);
        $response->assertSee('No Order Found');
    }
}
