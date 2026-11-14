<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $gaming = Category::create([
            'name' => 'Gaming',
            'slug' => 'gaming',
        ]);

        $accessories = Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Wireless Headphones',
            'slug' => 'wireless-headphones',
            'description' => 'Premium wireless headphones with noise cancellation.',
            'price' => 89.99,
            'stock' => 25,
            'rating' => 4.8,
            'featured' => true,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Smart Watch Pro',
            'slug' => 'smart-watch-pro',
            'description' => 'Modern smartwatch with health and fitness tracking.',
            'price' => 129.99,
            'stock' => 18,
            'rating' => 4.6,
            'featured' => true,
        ]);

        Product::create([
            'category_id' => $gaming->id,
            'name' => 'Mechanical Gaming Keyboard',
            'slug' => 'mechanical-gaming-keyboard',
            'description' => 'RGB mechanical keyboard designed for gaming.',
            'price' => 74.99,
            'stock' => 32,
            'rating' => 4.9,
            'featured' => true,
        ]);

        Product::create([
            'category_id' => $accessories->id,
            'name' => 'Premium Laptop Stand',
            'slug' => 'premium-laptop-stand',
            'description' => 'Aluminum laptop stand for a clean modern workspace.',
            'price' => 39.99,
            'stock' => 40,
            'rating' => 4.7,
            'featured' => false,
        ]);
    }
}