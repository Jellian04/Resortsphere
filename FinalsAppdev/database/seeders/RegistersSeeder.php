<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RegistersSeeder extends Seeder
{
    public function run()
{
    $faker = Faker::create();

    foreach (range(1, 50) as $index) {
        DB::table('registers')->insert([
            'username' => $faker->userName,
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'password' => \Hash::make('Password123!@#'), // Hashed password
        ]);
    }
}
}
