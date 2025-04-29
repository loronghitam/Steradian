<?php

namespace App\Http\Requests;

use App\Rules\Foreignuuid;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'dropoff_location' => 'bool',
            'dropoff_date' => "date",
            'pickup_date' => "date",
            'pickup_location' => "bool",
            'car_id' => new Foreignuuid
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
