<?php

namespace App\Rules;

use App\Models\Car;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Foreignuuid implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Str::isUuid($value)) {
            $fail("The $attribute Not Found");
        } else if (!Car::find($value)) {
            $fail("The $attribute Not Found");
        }
    }
}
