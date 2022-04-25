<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TripPolicy
{
    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return $user === Auth::user();
    }
}
