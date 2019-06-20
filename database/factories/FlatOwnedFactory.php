<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\FlatOwned;
use Faker\Generator as Faker;

$factory->define(FlatOwned::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    return [
        'id' => $faker->unique()->numberBetween(100, 900),
        'user_id' => $faker->randomElement($users),
    ];
});
