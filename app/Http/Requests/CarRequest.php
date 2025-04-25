<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_name' => 'required|string',
            'day_rate' => 'required|numeric',
            'month_rate' => 'required|numeric',
            'image' => 'required|image',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseError(400, 'Error', $validator->errors())
        );
    }
}
