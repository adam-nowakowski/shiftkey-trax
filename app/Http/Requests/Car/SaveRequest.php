<?php

namespace App\Http\Requests\Car;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('store', Car::class);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'trip_count' => 0,
            'trip_miles' => 0,
            'user_id' => auth()->id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'year' => 'required|integer|max:' . today()->year,
            'make' => 'required|string',
            'model' => 'string',
            'trip_count' => 'required',
            'trip_miles' => 'required',
            'user_id' => 'required',
        ];
    }
}
