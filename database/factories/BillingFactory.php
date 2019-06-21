<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Billing;
use Faker\Generator as Faker;

$factory->define(Billing::class, function (Faker $faker) {
    $flat = App\FlatOwned::pluck('id')->toArray();
    return [
        'title' => $faker->sentence(3),
        'amount' => rand(100, 300),
        'is_payed' => false,
        'due_date' => (new \DateTime("+30 day"))->format('Y-m-d'),
        'flat_id' => $faker->randomElement($flat),
    ];
});
