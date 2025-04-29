<?php

namespace App\Http\Requests;

use App\Rules\Foreignuuid;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'dropoff_location' => 'required|numeric',
            'dropoff_date' => "required|date",
            'pickup_date' => "required|date",
            'pickup_location' => "required|numeric",
            'car_id' => ["required", new Foreignuuid]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseError(400, 'Error', $validator->errors())
        );
    }
}
