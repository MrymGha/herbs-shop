<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have customers and products
        $customers = User::role('customer')->get();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No customers or products found. Please seed them first.');
            return;
        }

        // Create 10 fake orders
        foreach (range(1, 10) as $i) {
            $customer = $customers->random();

            $order = Order::create([
                'user_id'          => $customer->id,
                'status'           => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                'total'            => 0, // will be updated after items
                'shipping_name'    => $customer->name,
                'shipping_phone'   => fake()->phoneNumber(),
                'shipping_address' => fake()->address(),
                'notes'            => fake()->sentence(),
            ]);

            $total = 0;

            // Each order gets 1–3 random items
            foreach ($products->random(rand(1, 3)) as $product) {
                $quantity = rand(1, 5);
                $price = $product->price;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $price,
                ]);

                $total += $quantity * $price;
            }

            // Update order total
            $order->update(['total' => $total]);
        }

        $this->command->info('✅ Orders seeded successfully!');
    }
}


// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\Order;
// use App\Models\User;
// use App\Models\Product;

// class OrderSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Make sure we have some users & products first
//         $user = User::first() ?? User::factory()->create();
//         $product = Product::first() ?? Product::factory()->create();

//         // Create 5 demo orders
//         for ($i = 1; $i <= 5; $i++) {
//             Order::create([
//                 'user_id' => $user->id,
//                 'product_id' => $product->id,
//                 'quantity' => rand(1, 5),
//                 'status' => 'pending', // could be 'pending', 'completed', etc.
//             ]);
//         }
//     }
// }
