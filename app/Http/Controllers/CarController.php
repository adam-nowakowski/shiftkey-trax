<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\SaveRequest;
use App\Http\Resources\Car\CarCollection;
use App\Http\Resources\Car\CarResource;
use App\Models\Car;

class CarController extends Controller
{
    public function index(): CarCollection
    {
        return new CarCollection(Car::get([
            'id',
            'make',
            'model',
            'year'
        ]));
    }

    public function store(SaveRequest $request)
    {
        Car::create($request->validated());
    }

    public function show(Car $car): CarResource
    {
        return new CarResource($car);
    }

    public function destroy(Car $car)
    {
        $this->authorize('destroy', $car);

        $car->delete();
    }
}
