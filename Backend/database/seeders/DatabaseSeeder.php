<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = \App\Models\User::create([
            "first_name" => "Admin",
            "last_name" => "User",
            "username" => "admin",
            "email" => "admin@gmail.com",
            "status" => "active",
            "phone" => "03485562365",
            "password" => Hash::make(123456),
            "role" => 'admin'
        ]);

        Profile::create([
            "user_id" => $adminUser->id,
            "address_line_1" => "Address",
            "gender" => "male",
            "date_of_birth" => "12-12-2003",
        ]);

        $regularUser = \App\Models\User::create([
            "first_name" => "User",
            "last_name" => "User",
            "username" => "user",
            "email" => "user@gmail.com",
            "status" => "active",
            "phone" => "03485562365",
            "password" => Hash::make(123456),
            "role" => 'user'
        ]);

        Profile::create([
            "user_id" => $regularUser->id,
            "address_line_1" => "Address",
            "gender" => "male",
            "date_of_birth" => "12-12-2003",
        ]);
    }
}
