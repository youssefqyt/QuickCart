<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_cart_page(): void
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Shopping Cart');
    }

    public function test_can_add_in_stock_product_to_cart(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 10,
            'price' => 29.99,
        ]);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart');

        $cart = session('cart');
        $this->assertArrayHasKey($product->id, $cart);
        $this->assertEquals(2, $cart[$product->id]['quantity']);
    }

    public function test_cannot_add_out_of_stock_product(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 0,
        ]);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 1,
        ]);

        $response->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }

    public function test_cannot_add_quantity_exceeding_stock(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 3,
        ]);

        $response = $this->post(route('cart.add', $product), [
            'quantity' => 5,
        ]);

        $response->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }

    public function test_can_update_cart_quantity(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 10,
        ]);

        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 10.00,
                'quantity' => 1,
                'stock' => 10,
            ]
        ]]);

        $response = $this->post(route('cart.update', $product), [
            'quantity' => 4,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(4, session('cart')[$product->id]['quantity']);
    }

    public function test_can_remove_product_from_cart(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 10.00,
                'quantity' => 1,
            ]
        ]]);

        $response = $this->delete(route('cart.remove', $product));

        $response->assertSessionHas('success');
        $this->assertArrayNotHasKey($product->id, session('cart', []));
    }

    public function test_can_clear_entire_cart(): void
    {
        session(['cart' => [
            1 => ['id' => 1, 'name' => 'Item 1', 'price' => 10, 'quantity' => 1],
            2 => ['id' => 2, 'name' => 'Item 2', 'price' => 20, 'quantity' => 2],
        ]]);

        $response = $this->post(route('cart.clear'));

        $response->assertRedirect(route('cart.index'));
        $this->assertEmpty(session('cart', []));
    }
}
