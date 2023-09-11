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
            return true;
        }
        throw new ValidationFailed("The field `{$field}` is required.");
    }
}
