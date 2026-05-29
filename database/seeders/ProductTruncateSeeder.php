<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTruncateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints for SQLite
        DB::statement('PRAGMA foreign_keys = OFF');

        // Clear pivot table first
        DB::table('product_tag')->delete();

        // Clear products table
        DB::table('products')->delete();

        // Reset auto-increment counters (SQLite specific)
        DB::statement('DELETE FROM sqlite_sequence WHERE name="product_tag"');
        DB::statement('DELETE FROM sqlite_sequence WHERE name="products"');

        // Re-enable foreign key constraints
        DB::statement('PRAGMA foreign_keys = ON');

        $this->command->info('Product and product_tag tables cleared successfully.');
    }
}