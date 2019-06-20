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
            'name' => "Het Shah",
            'email' => "htshah60@gmail.com",
            'password' => Hash::make('helloworld'), // password
            'phone' => "9022349874",
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
