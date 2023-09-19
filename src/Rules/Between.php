<?php

declare(strict_types=1);

namespace Spotwilliams\Validator\Rules;

use Spotwilliams\Validator\Exceptions\ValidationFailed;
use Spotwilliams\Validator\Contracts\ValidationRule;

class Between implements ValidationRule
{
    private $field;
    private $value;
    private $constraint;

    /** @inheritDoc */
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = []): bool
    {
        $this->field = $field;
        $this->value = $value;
        $this->constraint = $constraint;

        $this->isValidFieldAndConstraints();

        return true;
    }

    /**
     * Validates the given values on arguments.
     *
     * @throws ValidationFailed If validation fails.
     */

    private function isValidFieldAndConstraints() : void
    {
        if(!empty($this->constraint) && is_array($this->constraint)) {
            if(!array_key_exists("min", $this->constraint) || !array_key_exists("max", $this->constraint)) {
                throw new ValidationFailed("The field `{$this->field}` validation requires a min & max constraint.");
            }
        } else {
            throw new ValidationFailed("The field `{$this->field}` validation requires a min & max constraint.");
        }

        if (!is_numeric($this->constraint["min"]) || !is_numeric($this->constraint["max"])) {
            throw new ValidationFailed("The validation min & max required numeric value, `{$this->constraint["min"]}` & `{$this->constraint["max"]}` given.");
        }

        if($this->valueLessThan($this->constraint["min"])) {
            throw new ValidationFailed("The field `{$this->field}` value is too low, allowed range is between {$this->constraint["min"]}-{$this->constraint["max"]}.");
        }

        if($this->valueGreaterThan($this->constraint["max"])) {
            throw new ValidationFailed("The field `{$this->field}` value is too high, allowed range is between {$this->constraint["min"]}-{$this->constraint["max"]}.");
        }
    }

    /**
     * Check if the given values smaller than comparator
     *
     * @return bool True if value smaller than comparator value.
     */
    private function valueLessThan(int|string $compare) : bool
    {
        return $this->value < $compare;
    }

    /**
     * Check if the given values greater than comparator
     *
     * @return bool True if value greater than comparator value.
     */

    private function valueGreaterThan(int|string $compare) : bool
    {
        return $this->value > $compare;
    }
}
