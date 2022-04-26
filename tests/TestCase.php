<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Lang;

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

    protected function getErrorMessage(string $field, string $type, int $max = null)
    {
        $error = str_replace(':attribute', $field, Lang::get("validation.{$type}"));

        if ($max) {
            return str_replace(':max', $max, $error);
        }

        return $error;
    }
}
