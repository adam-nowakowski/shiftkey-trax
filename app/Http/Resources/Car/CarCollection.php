<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CarCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($car) {
                return [
                    'id' => $car->id,
                    'make' => $car->make,
                    'model' => $car->model,
                    'year' => $car->year,
                ];
            }),
        ];
    }
}
