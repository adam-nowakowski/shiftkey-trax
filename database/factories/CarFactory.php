<?php

/** @var Factory $factory */

use App\Models\Car;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'make' => $faker->word,
        'model' => $faker->word,
        'year' => $faker->year,
    ];
});
