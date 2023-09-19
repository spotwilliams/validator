<?php

declare(strict_types=1);

namespace Spotwilliams\Validator\Rules;

use Spotwilliams\Validator\Exceptions\ValidationFailed;
use Spotwilliams\Validator\Contracts\ValidationRule;

class Required implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if ($value !== null) {
            if(is_string($value) && strlen(trim($value)) > 1) {
                return true;
            } elseif (is_array($value) && count($value) > 0) {
                return true;
            }
        }
        throw new ValidationFailed("The field `{$field}` is required.");
    }
}
