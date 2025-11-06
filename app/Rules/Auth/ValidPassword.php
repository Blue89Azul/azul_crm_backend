<?php

namespace App\Rules\Auth;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(':attributeは文字列で入力してください。');
            return;
        }

        if (strlen($value) < 8 || strlen($value) > 16) {
            $fail(':attributeは8文字以上、16文字以下の文字列で入力してください。');
            return;
        }

        if (!preg_match('/^[\x20-\x7E]+$/', $value)) {
            $fail(':attributeは半角英数字・半角記号のみ使用できます。');
            return;
        }

        if (!preg_match('/[A-Za-z]/', $value)) {
            $fail(':attributeは英字を一文字以上含めてください。');
        }

        if (!preg_match('/\d/', $value)) {
            $fail(':attributeは数字を1文字以上含めてください。');
            return;
        }
    }
}
