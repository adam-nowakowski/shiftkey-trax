<?php

namespace Tests\Unit\Controllers;

use App\Models\Car;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function testOnlyLoggedUserCanSeeCarsData()
    {
        $car = factory(Car::class)->create();

        $this->json('get', route('cars.index'))->assertUnauthorized();
        $this->json('post', route('cars.store'), factory(Car::class)->make()->toArray())
            ->assertUnauthorized();
        $this->json('get', route('cars.show', [
            'car' => $car
        ]))->assertUnauthorized();
        $this->json('delete', route('cars.destroy', [
            'car' => $car
        ]))->assertUnauthorized();

        $this->signIn();

        $car = factory(Car::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->json('get', route('cars.index'))->assertOk();
        $this->json('post', route('cars.store'), factory(Car::class)->make()->toArray())
            ->assertOk();
        $this->json('get', route('cars.show', [
            'car' => $car
        ]))->assertOk();
        $this->json('delete', route('cars.destroy', [
            'car' => $car
        ]))->assertOk();
    }

    public function testIndexMethodReturnsOnlyActiveCarsList()
    {
        $this->signIn();

        $carsCount = Car::count();

        self::assertEquals($carsCount, $this->get(route('cars.index'))->getOriginalContent()->count());

        factory(Car::class)->create();

        $carsCount++;

        self::assertEquals($carsCount, $this->get(route('cars.index'))->getOriginalContent()->count());

        factory(Car::class)->create([
            'deleted_at' => now()
        ]);

        self::assertEquals($carsCount, $this->get(route('cars.index'))->getOriginalContent()->count());
    }

    public function testStoreMethodStoresNewCar()
    {
        $this->signIn();

        $car = factory(Car::class)->make();
        $carTable = $car->getTable();
        $carData = $car->toArray();

        unset($carData['trip_count'], $carData['trip_miles'], $carData['user_id'], $carData['deleted_at']);

        $this->assertDatabaseMissing($carTable, $carData);

        $this->post(route('cars.store'), $carData);

        $this->assertDatabaseHas($carTable, $carData);
    }

    public function testDestroyMethodDeletesCar()
    {
        $this->signIn();

        $car = factory(Car::class)->create([
            'user_id' => $this->user->id
        ]);
        $carTable = $car->getTable();
        $carData = $car->toArray();

        $this->assertDatabaseHas($carTable, $carData);

        $this->delete(route('cars.destroy', [
            'car' => $car
        ]), $carData);

        $this->assertDatabaseMissing($carTable, $carData);
    }

    public function testUserWhoIsNotOwnerOfCarCannotDeleteIt()
    {
        $car = factory(Car::class)->create();

        $this->signIn();

        $this->json('delete', route('cars.destroy', [
            'car' => $car
        ]))->assertStatus(403);
    }
}
