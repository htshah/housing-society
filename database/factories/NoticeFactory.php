<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Notice;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2),
        'description' => $faker->sentence(5),
    ];
});
