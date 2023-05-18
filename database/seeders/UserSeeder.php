<?php

namespace Database\Seeders;

use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'adminnn',
            'phone_number' => '083212312312',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        $faker = Factory::create('id_ID');
        for ($i=1; $i < 10; $i++) {
            DB::table('users')->insert([
                'id' => Uuid::uuid4()->toString(),
                'name' => $faker->name(),
                'email' => $faker->email(),
                'username' => $faker->unique()->userName(),
                'phone_number' => '08' . mt_rand(0000000000, 9999999999),
                'password' => Hash::make('password'),
                'role' => 'sales'
            ]);
        }
    }
}
