<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\PromoCode;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\Cart;
use App\Models\WishList;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('123456'),
            'status' => 'active',
            'role' => 'admin',
        ]);

        Profile::create([
            'user_id' => $adminUser->id,
            'address_line_1' => 'Admin Address',
            'city' => 'Admin City',
            'state' => 'Admin State',
            'country' => 'Admin Country',
            'zip' => '12345',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
        ]);

        // Create Users with Profiles
        $users = [$adminUser]; // Start with admin user
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => \Faker\Factory::create()->firstName(),
                'last_name' => \Faker\Factory::create()->lastName(),
                'username' => \Faker\Factory::create()->unique()->userName(),
                'email' => \Faker\Factory::create()->unique()->safeEmail(),
                'phone' => \Faker\Factory::create()->phoneNumber(),
                'password' => bcrypt('password'),
                'status' => \Faker\Factory::create()->randomElement(['active', 'inactive']),
                'role' => 'user',
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'address_line_1' => \Faker\Factory::create()->streetAddress(),
                'city' => \Faker\Factory::create()->city(),
                'state' => \Faker\Factory::create()->state(),
                'country' => \Faker\Factory::create()->country(),
                'zip' => \Faker\Factory::create()->postcode(),
                'date_of_birth' => \Faker\Factory::create()->date(),
                'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other']),
            ]);

            $users[] = $user;
        }

        // Create Categories
        $categories = [];
        $categoryNames = ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports', 'Automotive', 'Health & Beauty', 'Toys & Games'];

        foreach ($categoryNames as $name) {
                        $categories[] = Category::create([
                'title' => $name,
                'description' => \Faker\Factory::create()->sentence(),
                'status' => 'active',
            ]);
        }

        // Create Brands
        $brands = [];
        $brandNames = ['Apple', 'Nike', 'Samsung', 'Adidas', 'Sony', 'LG', 'Canon', 'Dell'];

        foreach ($brandNames as $name) {
            $brands[] = Brand::create([
                'name' => $name,
                'description' => \Faker\Factory::create()->sentence(),
                'status' => 'active',
            ]);
        }

                // Create Inventories
        $inventories = [];
        for ($i = 1; $i <= 20; $i++) {
            $category = $categories[array_rand($categories)];
            $brand = $brands[array_rand($brands)];

            $inventories[] = Inventory::create([
                'name' => \Faker\Factory::create()->words(3, true),
                'description' => \Faker\Factory::create()->sentence(),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'price' => \Faker\Factory::create()->numberBetween(10, 500), // Price in cents
                'discounted_price' => \Faker\Factory::create()->optional(0.7)->numberBetween(500, 45000),
                'stock_quantity' => \Faker\Factory::create()->numberBetween(0, 100),
                'images' => null,
                'status' => \Faker\Factory::create()->randomElement(['active', 'inactive']),
            ]);
        }

        // Create Promo Codes
        $promoCodes = [];
        $promoData = [
            ['code' => 'SAVE20', 'discount' => 20, 'start_date' => now(), 'end_date' => now()->addMonths(3)],
            ['code' => 'WELCOME15', 'discount' => 15, 'start_date' => now(), 'end_date' => now()->addMonths(2)],
            ['code' => 'SUMMER30', 'discount' => 30, 'start_date' => now()->addDays(30), 'end_date' => now()->addMonths(4)],
            ['code' => 'FLASH25', 'discount' => 25, 'start_date' => now()->subDays(5), 'end_date' => now()->addDays(10)],
        ];

        foreach ($promoData as $promo) {
            $promoCodes[] = PromoCode::create([
                'code' => $promo['code'],
                'description' => \Faker\Factory::create()->sentence(),
                'discount_percentage' => $promo['discount'],
                'start_date' => $promo['start_date'],
                'end_date' => $promo['end_date'],
                'status' => 'active',
            ]);
        }

        // Create Orders with Order Details
        for ($i = 1; $i <= 15; $i++) {
            $user = $users[array_rand($users)];
            $promoCode = \Faker\Factory::create()->optional(0.3)->randomElement($promoCodes);

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'promo_code_id' => $promoCode ? $promoCode->id : null,
                'status' => \Faker\Factory::create()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
                'payment_status' => \Faker\Factory::create()->randomElement(['pending', 'paid', 'failed', 'refunded']),
                'shipping_address' => \Faker\Factory::create()->address(),
                'city' => \Faker\Factory::create()->city(),
                'state' => \Faker\Factory::create()->state(),
                'country' => \Faker\Factory::create()->country(),
                'zip' => \Faker\Factory::create()->postcode(),
                'sub_total' => 0,
                'total' => 0,
                'shipping_cost' => \Faker\Factory::create()->numberBetween(500, 2000), // Shipping cost in cents
            ]);

            // Create Order Details
            $numItems = \Faker\Factory::create()->numberBetween(1, 5);
            $subTotal = 0;

            for ($j = 1; $j <= $numItems; $j++) {
                $inventory = $inventories[array_rand($inventories)];
                $quantity = \Faker\Factory::create()->numberBetween(1, 3);
                $price = $inventory->discounted_price ?: $inventory->price;
                $total = $price * $quantity;
                $subTotal += $total;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'inventory_id' => $inventory->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ]);
            }

            // Calculate and update order totals
            $discount = 0;
            if ($promoCode) {
                $discount = ($promoCode->discount_percentage / 100) * $subTotal;
            }

            $order->update([
                'sub_total' => $subTotal,
                'total' => $subTotal - $discount + $order->shipping_cost,
            ]);
        }

        // Create Reviews
        for ($i = 1; $i <= 30; $i++) {
            $user = $users[array_rand($users)];
            $inventory = $inventories[array_rand($inventories)];

            Review::create([
                'user_id' => $user->id,
                'inventory_id' => $inventory->id,
                'rating' => \Faker\Factory::create()->numberBetween(1, 5),
                'comment' => \Faker\Factory::create()->paragraph(),
                'status' => 'active',
            ]);
        }

        // Create Carts
        for ($i = 1; $i <= 8; $i++) {
            $user = $users[array_rand($users)];
            $inventory = $inventories[array_rand($inventories)];

            Cart::create([
                'user_id' => $user->id,
                'inventory_id' => $inventory->id,
                'quantity' => \Faker\Factory::create()->numberBetween(1, 3),
            ]);
        }

        // Create Wish Lists
        for ($i = 1; $i <= 12; $i++) {
            $user = $users[array_rand($users)];
            $inventory = $inventories[array_rand($inventories)];

            WishList::create([
                'user_id' => $user->id,
                'inventory_id' => $inventory->id,
            ]);
        }
    }
}
