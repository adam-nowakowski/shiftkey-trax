<?php

namespace Tests\Unit\Requests;

use App\Models\Car;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class CarSaveTest extends TestCase
{
    public function testOnlyLoggedUserCanUseValidator()
    {
        $this->json('post', route('cars.store'), factory(Car::class)->make()->toArray())
            ->assertUnauthorized();

        $this->signIn();

        $this->json('post', route('cars.store'), factory(Car::class)->make()->toArray())
            ->assertOk();
    }

    public function testValidationWithEmptyData()
    {
        $this->signIn();

        $this->json('post', route('cars.store'), [])
            ->assertSessionMissing([
                'year',
                'make',
                'model',
            ]);
    }

    public function testValidationWithInvalidData()
    {
        $this->signIn();

        $response = $this->json('post', route('cars.store'), [
            'year' => str_random(),
            'make' => random_int(1, 10),
            'model' => random_int(1, 10),
        ]);

        $errors = $response->getOriginalContent();

        self::assertEquals('The given data was invalid.', $errors['message']);
        self::assertEquals($this->getErrorMessage('year', 'integer'), $errors['errors']['year'][0]);
        self::assertEquals($this->getErrorMessage('make', 'string'), $errors['errors']['make'][0]);
        self::assertEquals($this->getErrorMessage('model', 'string'), $errors['errors']['model'][0]);
    }

    public function testValidationWithInvalidYear()
    {
        $this->signIn();

        $response = $this->json('post', route('cars.store'), [
            'year' => random_int(today()->addYear()->year, today()->addCentury()->year),
        ]);

        self::assertEquals(
            $this->getErrorMessage('year', 'max', today()->year)['numeric'],
            $response->getOriginalContent()['errors']['year'][0]
        );
    }

    private function getErrorMessage(string $field, string $type, int $max = null)
    {
        $error = str_replace(':attribute', $field, Lang::get("validation.{$type}"));

        if ($max) {
            return str_replace(':max', $max, $error);
        }

        return $error;
    }
}
