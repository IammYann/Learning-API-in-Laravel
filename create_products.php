<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

for ($i = 1; $i <= 15; $i++) {
    Product::create([
        'name' => 'Bulk Product ' . $i,
        'description' => 'Auto-generated product ' . $i,
        'price' => 9.99 + $i,
        'category_id' => 1,
    ]);
}

echo "Created 15 products!\n";
