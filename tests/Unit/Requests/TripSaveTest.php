<?php

namespace Tests\Unit\Requests;

use App\Models\Car;
use App\Models\Trip;
use Tests\TestCase;

class TripSaveTest extends TestCase
{
    public function testOnlyLoggedUserCanUseValidator()
    {
        $this->json('post', route('trips.store'), factory(Trip::class)->make()->toArray())
            ->assertUnauthorized();

        $this->signIn();

        $car = factory(Car::class)->create();

        $this->json('post', route('trips.store'), factory(Trip::class)->make([
            'car_id' => $car
        ])->toArray());
    }

    public function testValidationWithEmptyData()
    {
        $this->signIn();

        $this->json('post', route('trips.store'), [])
            ->assertSessionMissing([
                'date',
                'car_id',
                '',
            ]);
    }


    public function testValidationWithInvalidData()
    {
        $this->signIn();

        $response = $this->json('post', route('trips.store'), [
            'date' => str_random(),
            'car_id' => str_random(),
            'miles' => str_random(),
        ]);

        $errors = $response->getOriginalContent();

        self::assertEquals('The given data was invalid.', $errors['message']);
        self::assertEquals($this->getErrorMessage('date', 'date'), $errors['errors']['date'][0]);
        self::assertEquals($this->getErrorMessage('car id', 'integer'), $errors['errors']['car_id'][0]);
        self::assertEquals($this->getErrorMessage('miles', 'numeric'), $errors['errors']['miles'][0]);
    }
}
