<?php

namespace Tests\Unit\Policies;

use App\Models\Trip;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class TripPolicyTest extends TestCase
{
    public function testCarStorePolicy()
    {
        self::assertFalse(Gate::allows('store', Trip::class));

        $this->signIn();

        self::assertTrue(Gate::allows('store', Trip::class));
    }
}
