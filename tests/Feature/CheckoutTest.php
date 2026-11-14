<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_checkout_with_empty_cart(): void
    {
        $response = $this->get(route('checkout.index'));
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('error');
    }

    public function test_can_view_checkout_page_with_items(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50.00,
            'stock' => 10,
        ]);

        $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 50.00,
                    'quantity' => 2,
                ]
            ]
        ]);

        $response = $this->get(route('checkout.index'));
        $response->assertStatus(200);
        $response->assertSee('Secure Checkout');
        $response->assertSee('$100.00');
    }

    public function test_can_place_order_with_cash_on_delivery(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 40.00,
            'stock' => 10,
        ]);

        $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 40.00,
                    'quantity' => 3,
                ]
            ]
        ]);

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Alice Walker',
            'customer_email' => 'alice@example.com',
            'address' => '456 Blossom Lane',
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Alice Walker',
            'customer_email' => 'alice@example.com',
            'total' => 120.00,
            'status' => 'processing',
        ]);

        // Verify stock was decremented
        $product->refresh();
        $this->assertEquals(7, $product->stock);

        // Verify cart was cleared
        $this->assertEmpty(session('cart', []));
    }

    public function test_cannot_checkout_if_item_exceeds_stock(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 25.00,
            'stock' => 1,
        ]);

        $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 25.00,
                    'quantity' => 5,
                ]
            ]
        ]);

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Bob Builder',
            'customer_email' => 'bob@example.com',
            'address' => '12 Construction Rd',
            'payment_method' => 'cod',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('orders', [
            'customer_email' => 'bob@example.com',
        ]);
    }

    public function test_success_page_clears_cart_and_shows_order(): void
    {
        $order = Order::factory()->create([
            'customer_name' => 'Charlie Day',
            'customer_email' => 'charlie@example.com',
            'total' => 75.00,
        ]);

        $this->withSession([
            'cart' => [
                1 => ['id' => 1, 'name' => 'Item', 'price' => 75, 'quantity' => 1]
            ]
        ]);

        $response = $this->get(route('checkout.success', ['order_id' => $order->id]));

        $response->assertStatus(200);
        $response->assertSee('Thank You for Your Order!');
        $response->assertSee('Charlie Day');
        $this->assertEmpty(session('cart', []));
    }
}
