<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_admin_dashboard(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);
        Order::factory()->count(2)->paid()->create(['total' => 100]);

        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee('Total Revenue');
    }

    public function test_can_list_and_create_categories(): void
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Categories');

        $response = $this->post(route('admin.categories.store'), [
            'name' => 'Audio Gear',
            'slug' => 'audio-gear',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Audio Gear',
            'slug' => 'audio-gear',
        ]);
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create(['name' => 'Old Name']);

        $response = $this->put(route('admin.categories.update', $category), [
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_cannot_delete_category_with_products(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('admin.categories.destroy', $category));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_can_delete_empty_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_can_list_and_create_products(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(200);

        $response = $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Noise Cancelling Headphones',
            'description' => 'Great sound quality',
            'price' => 199.99,
            'stock' => 15,
            'rating' => 4.8,
            'featured' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Noise Cancelling Headphones',
            'stock' => 15,
        ]);
    }

    public function test_can_list_orders_and_filter_by_status(): void
    {
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'delivered']);

        $response = $this->get(route('admin.orders.index', ['status' => 'delivered']));
        $response->assertStatus(200);
        $response->assertSee('Delivered');
    }

    public function test_can_view_order_details_and_update_status(): void
    {
        $order = Order::factory()->create([
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $response = $this->get(route('admin.orders.show', $order));
        $response->assertStatus(200);
        $response->assertSee('Order #' . $order->id);

        $response = $this->put(route('admin.orders.update', $order), [
            'status' => 'shipped',
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'shipped',
            'payment_status' => 'paid',
        ]);
    }
}
