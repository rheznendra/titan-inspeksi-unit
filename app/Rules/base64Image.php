<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class base64Image implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Must be a string
        if (!is_string($value)) {
            $fail(':Attribute tidak valid.');
            return;
        }

        // Strip data URI if present
        if (str_starts_with($value, 'data:image/jpeg;base64,')) {
            $value = substr($value, strlen('data:image/jpeg;base64,'));
        }

        // Decode base64
        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            $fail(':Attribute tidak valid.');
            return;
        }

        // Check MIME type
        $finfo = finfo_open();
        $mime = finfo_buffer($finfo, $decoded, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        if ($mime !== 'image/jpeg') {
            $fail(':Attribute tidak valid.');
        }
    }
}
