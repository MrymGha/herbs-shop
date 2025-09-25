<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('No categories found. Please run CategoriesSeeder first.');
            return;
        }

        $productsData = [
            [
                'name' => 'Herbal Tea',
                'description' => 'Refreshing herbal tea for daily use.',
                'price' => 25.50,
                'stock' => 50,
                'image' => 'herbal_tea.png',
            ],
            [
                'name' => 'Aloe Vera Gel',
                'description' => 'Soothing gel for skin hydration.',
                'price' => 15.75,
                'stock' => 40,
                'image' => 'aloe_vera.png',
            ],
            [
                'name' => 'Organic Honey',
                'description' => 'Pure organic honey from local farms.',
                'price' => 45.00,
                'stock' => 30,
                'image' => 'honey.png',
            ],
            // Add more products if needed...
        ];

        foreach ($productsData as $data) {
            $product = new Product($data);
            $product->category_id = $categories->random()->id; // Assign a random category
            $product->slug = Str::slug($data['name']);
            $product->save();
        }
    }
}
