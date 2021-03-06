<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TripSaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('store', Trip::class);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'car_id' => 'required|integer',
            'miles' => 'required|numeric',
            'user_id' => 'required',
        ];
    }

    public function validated(): array
    {
        return array_merge(parent::validated(), [
            'date' => Carbon::parse($this->date),
        ]);
    }
}
