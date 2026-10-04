<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Product::updateOrCreate(['key' => 'test'], [
            'name' => 'Test Product',
            'description' => 'Low-price product for live payment testing',
            'price' => '0.100',
            'currency' => 'BHD',
            'active' => true,
            'sort_order' => 99,
        ]);
    }

    public function down(): void
    {
        Product::where('key', 'test')->delete();
    }
};
