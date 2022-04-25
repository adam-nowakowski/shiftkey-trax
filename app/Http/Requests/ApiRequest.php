<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errorString = '';

        foreach ($validator->errors()->getMessages() as $message) {
            $errorString .= implode(' ', $message) . ' ';
        }

        $response = response(trim($errorString), 422);

        throw new ValidationException($validator, $response);
    }
}
