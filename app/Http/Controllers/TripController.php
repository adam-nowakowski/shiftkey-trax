<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripSaveRequest;
use App\Http\Resources\Trip\TripCollection;
use App\Models\Trip;

class TripController extends Controller
{
    public function index(): TripCollection
    {
        return new TripCollection(Trip::forLoggedUser()->with('car:id,make,model,year')->get());
    }

    public function store(TripSaveRequest $request)
    {
        Trip::createTrip($request->validated());
    }
}
