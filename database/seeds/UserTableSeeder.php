<?php

use Illuminate\Database\Seeder;

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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => "9022349874",
            'role' => 'admin',
            'is_active' => true,
        ]);
        DB::table('user')->insert([
            'name' => "John Abraham",
            'email' => "john@gmail.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => "987654123",
            'role' => 'user',
            'is_active' => true,
        ]);

        factory('App\User', 100)->create();
    }
}
