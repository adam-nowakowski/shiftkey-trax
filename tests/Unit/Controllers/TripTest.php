<?php

namespace Tests\Unit\Controllers;

use App\Models\Car;
use App\Models\Trip;
use Tests\TestCase;

class TripTest extends TestCase
{
    public function testOnlyLoggedUserCanSeeTripsData()
    {
        $car = factory(Car::class)->create();
        $tripData = factory(Trip::class)->make([
            'car_id' => $car->id
        ])->toArray();

        $this->json('get', route('trips.index'))->assertUnauthorized();
        $this->json('post', route('trips.store'), $tripData)->assertUnauthorized();

        $this->signIn();

        $this->json('get', route('trips.index'))->assertOk();
        $this->json('post', route('trips.store'), $tripData)->assertOk();
    }

    public function testIndexMethodCanReturnAllCarsList()
    {
        $this->signIn();

        factory(Trip::class)->create([
            'user_id' => $this->user->id
        ]);

        self::assertEquals(
            Trip::forLoggedUser()->count(),
            $this->get(route('trips.index'))->getOriginalContent()->count()
        );
    }

    public function testStoreMethodStoresNewTrip()
    {
        $this->signIn();

        $trip = factory(Trip::class)->make([
            'car_id' => factory(Car::class)->create()->id
        ]);
        $tripTable = $trip->getTable();
        $tripData = $trip->toArray();

        unset($tripData['user_id']);

        $this->assertDatabaseMissing($tripTable, $tripData);

        $this->post(route('trips.store'), $tripData);

        $this->assertDatabaseHas($tripTable, $tripData);
    }

    public function testAdditionalAttributesAreAddedWhileStoringTheTrip()
    {
        $this->signIn();

        $trip = factory(Trip::class)->make();
        $tripData = $trip->toArray();

        self::assertNotEquals($this->user->id, $trip->user_id);

        unset($tripData['user_id']);

        $this->post(route('trips.store'), $tripData);

        $addedTrip = Trip::orderBy('id', 'desc')->first();

        self::assertEquals($this->user->id, $addedTrip->user_id);
    }
}
