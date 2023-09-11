<?php

declare(strict_types=1);

namespace Spotwilliams\Validator\Rules;

use Spotwilliams\Validator\Exceptions\SkipNextRules;
use Spotwilliams\Validator\Contracts\ValidationRule;

class Nullable implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        if ($value === null) {
            throw new SkipNextRules();
        }

        return true;
    }
}
