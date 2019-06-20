<?php

use Illuminate\Database\Seeder;

class FlatOwnedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\FlatOwned', 100)->create();
    }
}
