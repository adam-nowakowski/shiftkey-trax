<?php

namespace App\Http\Resources\Trip;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TripCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $totalMiles = $this->collection->sum('miles');

        return [
            'data' => $this->collection->map(function ($trip) use (&$totalMiles) {
                $tripData = [
                    'id' => $trip->id,
                    'date' => $trip->date,
                    'miles' => $trip->miles,
                    'total' => $totalMiles,
                    'car' => $trip->car,
                ];

                $totalMiles = $totalMiles - $trip->miles;

                return $tripData;
            }),
        ];
    }
}
