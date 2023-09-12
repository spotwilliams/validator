<?php

declare(strict_types=1);

namespace Spotwilliams\Validator\Rules;

use Spotwilliams\Validator\Exceptions\ValidationFailed;
use Spotwilliams\Validator\Contracts\ValidationRule;

class Between implements ValidationRule
{
    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = []): bool
    {
        if(!empty($constraint) && is_array($constraint)) {
            if(!array_key_exists("min", $constraint) || !array_key_exists("max", $constraint)) {
                throw new ValidationFailed("The field `{$field}` validation requires a min & max constraint.");
            }

            if (!is_numeric($constraint["min"]) || !is_numeric($constraint["max"])) {
                throw new ValidationFailed("The validation min & max required numeric value, `{$constraint["min"]}` & `{$constraint["max"]}` given.");
            }

            if($value < intval($constraint["min"])) {
                throw new ValidationFailed("The field `{$field}` value is too low, allowed range is between {$constraint["min"]}-{$constraint["max"]}.");
            }

            if($value > intval($constraint["max"])) {
                throw new ValidationFailed("The field `{$field}` value is too high, allowed range is between {$constraint["min"]}-{$constraint["max"]}.");
            }

            return true;
        } else {
            throw new ValidationFailed("The field `{$field}` validation requires a min & max constraint.");
        }
    }
}
