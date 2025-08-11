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
        \App\Models\User::create([
            "first_name" => "Admin",
            "last_name" => "User",
            "username" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make(123456),
            "profile_id" => 1,
            "role" => 'admin'
        ]);

        Profile::create([
            "address_line_1" => "Address",
            "phone" => "03485562365",
            "gender" => "male",
            "date_of_birth" => "12-12-2003",
        ]);
    }
}
