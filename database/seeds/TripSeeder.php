<?php

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $trip = factory(Trip::class)->create([
                'car_id' => Car::inRandomOrder()->value('id') ?: rand(),
                'user_id' => User::inRandomOrder()->value('id') ?: rand()
            ]);

            $car = $trip->car;

            $car->update([
                'trip_count' => $car->trip_count + 1,
                'trip_miles' => $car->trip_miles + $trip->miles,
            ]);
        }
    }
}
