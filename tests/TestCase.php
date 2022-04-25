<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $user;

    protected function signIn(User $user = null)
    {
        $this->user = $user ?: factory(User::class)->create();

        $this->actingAs($this->user, 'api');
    }
}
