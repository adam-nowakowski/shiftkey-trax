<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $fillable = [
        'date',
        'miles',
        'car_id',
        'user_id',
    ];

    public function scopeForLoggedUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class)->withTrashed();
    }

    public static function createTrip(array $storeData)
    {
        DB::beginTransaction();

        $trip = Trip::create($storeData);
        $car = $trip->car;

        $car->update([
            'trip_count' => $car->trip_count + 1,
            'trip_miles' => $car->trip_miles + $trip->miles,
        ]);

        DB::commit();
    }
}
