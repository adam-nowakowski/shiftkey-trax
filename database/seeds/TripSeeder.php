<?php

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Trip::class, 5)->create([
            'car_id' => Car::inRandomOrder()->value('id') ?: rand()
        ]);

        factory(Trip::class, 5)->create([
            'car_id' => Car::inRandomOrder()->value('id') ?: rand()
        ]);
    }
}
