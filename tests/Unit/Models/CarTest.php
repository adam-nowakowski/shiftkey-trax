<?php

namespace Tests\Unit\Models;

use App\Models\Car;
use App\Models\User;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function testCarsUserRelation()
    {
        $user = factory(User::class)->create();
        $car = factory(Car::class)->create([
            'user_id' => $user->id
        ]);

        self::assertInstanceOf(User::class, $car->user);
        self::assertSame($user->id, $car->user->id);
    }
}
