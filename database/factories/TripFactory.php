<?php

/** @var Factory $factory */

use App\Models\Trip;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Trip::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'miles' => $faker->randomFloat(2, 0, 100),
        'user_id' => $faker->numberBetween(),
        'car_id' => $faker->numberBetween(),
    ];
});
