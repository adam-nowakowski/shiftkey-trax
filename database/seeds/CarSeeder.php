<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Car::class, 10)->create([
            'user_id' => User::inRandomOrder()->value('id') ?: rand(),
            'trip_count' => 0,
            'trip_miles' => 0,
        ]);
    }
}
