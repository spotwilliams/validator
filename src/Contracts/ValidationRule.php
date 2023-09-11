<?php

namespace Spotwilliams\Validator\Contracts;

use Spotwilliams\Validator\Exceptions\ValidationFailed;

interface ValidationRule
{
    /**
     * Applies the validation rule to a field's value.
     *
     * @param string $ruleName The name of the rule being applied.
     * @param string $field The name of the field being validated.
     * @param mixed|null $value The value of the field being validated.
     * @param mixed|null $constraint Any additional constraint required for the validation rule.
     * @return bool Whether the validation rule succeeded.
     * @throws ValidationFailed If the validation rule fails.
     */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool;
}
