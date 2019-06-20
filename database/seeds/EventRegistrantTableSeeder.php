<?php

use Illuminate\Database\Seeder;

class EventRegistrantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\EventRegistrant', 100)->create();
    }
}
