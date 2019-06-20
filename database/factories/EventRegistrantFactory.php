<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\EventRegistrant;
use Faker\Generator as Faker;

$factory->define(EventRegistrant::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    $event = App\Event::pluck('id')->toArray();
    return [
        'event_id' => $faker->randomElement($event),
        'user_id' => $faker->randomElement($users),
        'no_of_people' => $faker->numberBetween(1, 5),
    ];
});
