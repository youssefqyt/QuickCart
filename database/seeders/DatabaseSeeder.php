<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            ['name' => 'Electronics']
        );

        $gaming = Category::firstOrCreate(
            ['slug' => 'gaming'],
            ['name' => 'Gaming']
        );

        $accessories = Category::firstOrCreate(
            ['slug' => 'accessories'],
            ['name' => 'Accessories']
        );

        Product::firstOrCreate(
            ['slug' => 'wireless-headphones'],
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation.',
                'price' => 89.99,
                'stock' => 25,
                'rating' => 4.8,
                'featured' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'smart-watch-pro'],
            [
                'category_id' => $electronics->id,
                'name' => 'Smart Watch Pro',
                'description' => 'Modern smartwatch with health and fitness tracking.',
                'price' => 129.99,
                'stock' => 18,
                'rating' => 4.6,
                'featured' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'mechanical-gaming-keyboard'],
            [
                'category_id' => $gaming->id,
                'name' => 'Mechanical Gaming Keyboard',
                'description' => 'RGB mechanical keyboard designed for gaming.',
                'price' => 74.99,
                'stock' => 32,
                'rating' => 4.9,
                'featured' => true,
            ]
        );

        Product::firstOrCreate(
            ['slug' => 'premium-laptop-stand'],
            [
                'category_id' => $accessories->id,
                'name' => 'Premium Laptop Stand',
                'description' => 'Aluminum laptop stand for a clean modern workspace.',
                'price' => 39.99,
                'stock' => 40,
                'rating' => 4.7,
                'featured' => false,
            ]
        );
    }
}
