<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarSaveRequest;
use App\Http\Resources\Car\CarCollection;
use App\Http\Resources\Car\CarResource;
use App\Models\Car;

class CarController extends Controller
{
    public function index(bool $all = false): CarCollection
    {
        $carsData = $all ? Car::withTrashed()->get() : Car::get();

        return new CarCollection($carsData);
    }

    public function store(CarSaveRequest $request)
    {
        Car::create($request->validated());
    }

    public function show(int $carId): CarResource
    {
         return new CarResource(Car::withTrashed()->find($carId));
    }

    public function destroy(Car $car)
    {
        $this->authorize('destroy', $car);

        $car->delete();
    }
}
