<?php

declare(strict_types=1);

namespace Spotwilliams\Validator;

use Spotwilliams\Validator\Contracts\ValidationRule;
use Spotwilliams\Validator\Exceptions\SkipNextRules;
use Spotwilliams\Validator\Exceptions\ValidationFailed;

class Validator
{
    private array $rules = [
        'datetime_iso' => Rules\DateTimeIso::class,
        'later_than_datetime_iso' => Rules\DateTimeIsoLaterThan::class,
        'hex_color' => Rules\HexColor::class,
        'in' => Rules\In::class,
        'nullable' => Rules\Nullable::class,
        'required' => Rules\Required::class,
        'string_length' => Rules\StringLength::class,
    ];

    /**
     * Validates the given values using the specified rules.
     *
     * @param array $values The values to validate.
     * @param array $rules An array of validation rules to apply to the values.
     * Each rule is an associative array with a rule name as the key and a constraint or constraint name as the value.
     * If the value is a constraint, it is used as a parameter to the rule.
     * @return bool True if validation passes.
     * @throws ValidationFailed If validation fails.
     */
    public function validate(array $values, array $rules): bool
    {
        foreach ($rules as $inputName => $constraints) {
            foreach ($constraints as $rule => $constraintOrName) {

                $ruleName = is_string($rule) ? $rule : $constraintOrName;
                $constraint = is_string($rule) ? $constraintOrName : null;
                try {
                    $this->findRule($ruleName)->apply(
                        ruleName: $ruleName,
                        field: $inputName,
                        value: $values[$inputName] ?? null,
                        constraint: $constraint
                    );
                } catch (SkipNextRules $e) {
                    continue 2;
                }
            }
        }

        return true;
    }

    /**
     * Finds and returns the validation rule with the specified name.
     *
     * @param string $name The name of the rule to find.
     * @return ValidationRule The found validation rule.
     * @throws \Exception If the rule is not found.
     */
    private function findRule(string $name): ValidationRule
    {
        if (isset($this->rules[$name])) {
            return new  $this->rules[$name]();
        }
        throw new \Exception('validation rule not found');
    }

}
