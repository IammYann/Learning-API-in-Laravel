<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create users (existing code)
        \App\Models\User::factory(0)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test_' . now()->timestamp. '@example.com',
        ]);

        // Create categories
        $categories = Category::factory(1)->create();

        // Create tags
        $tags = Tag::factory(1)->create();

        // Create products with categories and attach random tags
        Product::factory(25000)->create()->each(function ($product) use ($categories, $tags) {
            // Assign a random category
            $product->category_id = $categories->random()->id;
            $product->save();

            // Attach 1-3 random tags
            $randomTagCount = min(rand(1, 3), $tags->count());
            $product->tags()->attach(
                $tags->random($randomTagCount)->pluck('id')->toArray()
            );
        });
    }
}