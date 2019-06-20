<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->words(5, true),
        'description' => $faker->sentence(3, true),
        'amount' => rand(100, 300),
        'end_time' => (new \DateTime("+30 day"))->format('Y-m-d'),
    ];
});
