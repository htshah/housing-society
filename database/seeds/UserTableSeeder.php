<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name' => "Git Hub",
            'email' => "demo@example.com",
            'password' => Hash::make('helloworld'), // password
            'phone' => "9874563210",
            'role' => 'admin',
            'is_active' => true,
        ]);
        DB::table('user')->insert([
            'name' => "John Abraham",
            'email' => "john@gmail.com",
            'password' => Hash::make('helloworld'), // password
            'phone' => "987654123",
            'role' => 'user',
            'is_active' => true,
        ]);

        factory('App\User', 100)->create();
    }
}
