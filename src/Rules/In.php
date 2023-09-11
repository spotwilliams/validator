<?php

declare(strict_types=1);

namespace Spotwilliams\Validator\Rules;

use Spotwilliams\Validator\Exceptions\ValidationFailed;
use Spotwilliams\Validator\Contracts\ValidationRule;

class In implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if(in_array($value, $constraint)) {
            return true;
        }

        throw new ValidationFailed("The value for field `{$field}` is not in the required list: " . implode(',', $constraint));
    }
}
