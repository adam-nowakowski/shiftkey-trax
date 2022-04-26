<?php

namespace Tests\Unit\Controllers;

use App\Models\Car;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function testOnlyLoggedUserCanSeeCarsData()
    {
        $carData = factory(Car::class)->make()->toArray();
        $car = factory(Car::class)->create($carData);

        $this->json('get', route('cars.index'))->assertUnauthorized();
        $this->json('post', route('cars.store'), $carData)->assertUnauthorized();
        $this->json('get', route('cars.show', [
            'car_id' => $car
        ]))->assertUnauthorized();
        $this->json('delete', route('cars.destroy', [
            'car' => $car
        ]))->assertUnauthorized();

        $this->signIn();

        $car = factory(Car::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->json('get', route('cars.index'))->assertOk();
        $this->json('post', route('cars.store'), $carData)->assertOk();
        $this->json('get', route('cars.show', [
            'car_id' => $car
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

    public function testIndexMethodCanReturnAllCarsList()
    {
        $this->signIn();

        $carsCount = Car::count();

        factory(Car::class)->create([
            'deleted_at' => now()
        ]);

        $trashedCarsCount = Car::withTrashed()->count();

        self::assertEquals($carsCount, $this->get(route('cars.index'))->getOriginalContent()->count());
        self::assertEquals($trashedCarsCount, $this->get(route('cars.index', ['all' => true]))->getOriginalContent()->count());
    }

    public function testShowMethodCanReturnCarData()
    {
        $this->signIn();

        $car = factory(Car::class)->create([
            'user_id' => $this->user->id,
            'deleted_at' => now()
        ]);

        $responseContent = json_decode($this->get(route('cars.show', [
            'car_id' => $car->id
        ]))->getContent())->data;

        self::assertSame($car->make, $responseContent->make);
        self::assertSame($car->model, $responseContent->model);
        self::assertSame($car->year, $responseContent->year);
        self::assertSame($car->trip_count, $responseContent->trip_count);
        self::assertSame($car->trip_miles, $responseContent->trip_miles);
        self::assertSame($car->user->name, $responseContent->owner);
        self::assertTrue($responseContent->can_delete);
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

    public function testAdditionalAttributesAreAddedWhileStoringTheCar()
    {
        $this->signIn();

        $car = factory(Car::class)->make();
        $carData = $car->toArray();

        self::assertNotEquals($this->user->id, $car->user_id);
        self::assertNotEquals(0, $car->trip_count);
        self::assertNotEquals(0, $car->trip_miles);

        unset($carData['trip_count'], $carData['trip_miles'], $carData['user_id'], $carData['deleted_at']);

        $this->post(route('cars.store'), $carData);

        $addedCar = Car::orderBy('id', 'desc')->first();

        self::assertEquals($this->user->id, $addedCar->user_id);
        self::assertEquals(0, $addedCar->trip_count);
        self::assertEquals(0, $addedCar->trip_miles);
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
