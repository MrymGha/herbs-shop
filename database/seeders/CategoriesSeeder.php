<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Herbs', 'slug' => 'herbs'],
            ['name' => 'Oils', 'slug' => 'oils'],
            ['name' => 'Skin Care', 'slug' => 'skin-care'],
            ['name' => 'Supplements', 'slug' => 'supplements'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
