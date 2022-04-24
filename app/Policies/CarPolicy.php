<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CarPolicy
{
    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return $user === Auth::user();
    }

    public function destroy(User $user, Car $car): bool
    {
        return $user->id === $car->user_id;
    }
}
