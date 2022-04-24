<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => [
                'make' => $this->make,
                'model' => $this->model,
                'year' => $this->year,
                'trip_count' => $this->trip_count,
                'trip_miles' => $this->trip_miles,
            ]
        ];
    }
}
