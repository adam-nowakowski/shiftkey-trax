<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\Trip;
use App\Policies\CarPolicy;
use App\Policies\TripPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Car::class => CarPolicy::class,
        Trip::class => TripPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
