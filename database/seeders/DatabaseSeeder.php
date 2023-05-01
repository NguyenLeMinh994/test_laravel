<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // create new user
        DB::table('users')->insert([
            [
                'name' => 'john',
                'email' => 'john@example.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'jane',
                'email' => 'jane@example.com',
                'password' => Hash::make('abcdef'),
            ]
        ]);

        DB::table('stores')->insert([
            [
                'user_id' => '1',
                'name' => 'Store A',
                'description' => 'This is Store A',
            ],
            [
                'user_id' => '1',
                'name' => 'Store B',
                'description' => 'This is Store B',
            ],
            [
                'user_id' => '2',
                'name' => 'Store C',
                'description' => 'This is Store C',
            ]
        ]);

        DB::table('products')->insert(
            [
                [
                    'store_id' => '1',
                    'name' => 'Product A',
                    'description' => 'This is Product A',
                    'price' => 10.00,
                    'quantity' => 100,
                ],
                [
                    'store_id' => '1',
                    'name' => 'Product B',
                    'description' => 'This is Product B',
                    'price' => 20.00,
                    'quantity' => 50,
                ],
                [
                    'store_id' => '2',
                    'name' => 'Product C',
                    'description' => 'This is Product C',
                    'price' => 15.00,
                    'quantity' => 75,
                ],
                [
                    'store_id' => '2',
                    'name' => 'Product C',
                    'description' => 'This is Product C',
                    'price' => 25.00,
                    'quantity' => 30,
                ]
            ]
        );


    }
}
