<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::updateOrCreate(['key' => 'coaching'], [
            'name' => 'Coaching Session',
            'description' => '1-on-1 coaching session',
            'price' => '60.000',
            'currency' => 'BHD',
            'active' => true,
            'sort_order' => 1,
        ]);

        Product::updateOrCreate(['key' => 'ufuq'], [
            'name' => 'Ufuq Career Assessment',
            'description' => 'Comprehensive career assessment and guidance report',
            'price' => '25.000',
            'currency' => 'BHD',
            'active' => true,
            'sort_order' => 2,
        ]);
    }
}
