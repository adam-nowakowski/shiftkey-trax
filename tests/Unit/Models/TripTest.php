<?php

namespace Tests\Unit\Models;

use App\Models\Car;
use App\Models\Trip;
use Tests\TestCase;

class TripTest extends TestCase
{
    public function testTripsCarRelation()
    {
        $car = factory(Car::class)->create([
            'deleted_at' => now()
        ]);
        $trip = factory(Trip::class)->create([
            'car_id' => $car->id
        ]);

        self::assertInstanceOf(Car::class, $trip->car);
        self::assertSame($car->id, $trip->car->id);
    }

    public function testForLoggedUserScopeReturnsLoggedUserTrips()
    {
        $this->signIn();

        factory(Trip::class)->create();

        factory(Trip::class)->create([
            'user_id' => $this->user->id
        ]);

        $loggedUserTrips = Trip::forLoggedUser()->get()->toArray();

        self::assertNotSame(
            $loggedUserTrips,
            Trip::get()->toArray()
        );

        self::assertSame(
            $loggedUserTrips,
            Trip::where('user_id', auth()->id())->get()->toArray()
        );
    }

    public function testCreateTripMethodCreatesTripAndUpdatesCarData()
    {
        $car = factory(Car::class)->create([
            'trip_count' => 0,
            'trip_miles' => 0,
        ]);

        $tripData = factory(Trip::class)->make([
            'car_id' => $car->id
        ]);

        Trip::createTrip($tripData->toArray());

        $car = $car->refresh();

        self::assertSame(1, $car->trip_count);
        self::assertSame($tripData->miles, $car->trip_miles);
    }
}
