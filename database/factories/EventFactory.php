<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    return [
        'title' => $faker->sentence(2),
        'description' => $faker->sentence(6),
        'amount' => rand(100, 300),
        'end_time' => (new \DateTime("+30 day"))->format('Y-m-d'),
        'user_id' => $faker->randomElement($users),
    ];
});
