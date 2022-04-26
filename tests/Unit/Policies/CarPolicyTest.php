<?php

namespace Tests\Unit\Policies;

use App\Models\Car;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CarPolicyTest extends TestCase
{
    public function testCarStorePolicy()
    {
        self::assertFalse(Gate::allows('store', Car::class));

        $this->signIn();

        self::assertTrue(Gate::allows('store', Car::class));
    }

    public function testCarDestroyPolicy()
    {
        $car = factory(Car::class)->create();

        self::assertFalse(Gate::allows('destroy', $car));

        $this->signIn();

        $car = factory(Car::class)->create([
            'user_id' => $this->user->id
        ]);

        self::assertTrue(Gate::allows('destroy', $car));
    }
}
