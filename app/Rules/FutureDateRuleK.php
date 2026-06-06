<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDateRuleK implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtotime($value) <= time()) {
            $fail('The :attribute must be a future date.');
        }
    }
}
