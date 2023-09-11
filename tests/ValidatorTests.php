<?php

declare(strict_types=1);

namespace Tests;

use Spotwilliams\Validator\Contracts\ValidationRule;
use Spotwilliams\Validator\Exceptions\ValidationFailed;

class ValidatorTests extends TestCase
{
    public function test_validate_required_field()
    {
        $rules = [
            'field_1' => ['required']
        ];

        $result = $this->validator->validate(values: ['field_1' => 'value'], rules: $rules);

        self::assertTrue($result);

        $this->expectException(ValidationFailed::class);

        $this->validator->validate(values: ['another_field' => 'value'], rules: $rules);
    }

    public function test_can_validate_more_than_one_rule()
    {
        $rules = [
            'field_1' => ['required', 'in' => ['value', 'another value']],
        ];

        try {
            $this->validator->validate(values: ['field_1' => null], rules: $rules);
        } catch (ValidationFailed $e) {
            self::assertEquals('The field `field_1` is required.', $e->getMessage());
            self::assertInstanceOf(ValidationFailed::class, $e);
        }

        try {
            $this->validator->validate(values: ['field_1' => 'bad value'], rules: $rules);
        } catch (ValidationFailed $e) {
            self::assertEquals('The value for field `field_1` is not in the required list: value,another value', $e->getMessage());
            self::assertInstanceOf(ValidationFailed::class, $e);
        }

        $result = $this->validator->validate(values: ['field_1' => 'value'], rules: $rules);

        self::assertTrue($result);
    }

    public function test_can_validate_null_values()
    {
        $rules = [
            'field_1' => ['nullable', 'in' => ['value', 'another value']],
        ];

        $result = $this->validator->validate(values: ['field_1' => null], rules: $rules);
        self::assertTrue($result);

        $result = $this->validator->validate(values: ['field_1' => 'value'], rules: $rules);
        self::assertTrue($result);

        try {
            $this->validator->validate(values: ['field_1' => 'bad value'], rules: $rules);
        } catch (ValidationFailed $e) {
            self::assertEquals('The value for field `field_1` is not in the required list: value,another value', $e->getMessage());
            self::assertInstanceOf(ValidationFailed::class, $e);
        }
    }


    public function test_can_add_new_rule_dynamically()
    {
        $rules = ['field_1' => ['is_phi']];

        $this->validator->registerRule('is_phi', new class implements ValidationRule {
            public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
            {
                if ($value === 3.14) {
                    return true;
                }
                throw new ValidationFailed("The value for field `{$field}` is not Phi (3.15), you provided: {$value}.");
            }
        });


        try {
            $this->validator->validate(values: ['field_1' => 3.15], rules: $rules);
        } catch (ValidationFailed $e) {
            self::assertEquals('The value for field `field_1` is not Phi (3.15), you provided: 3.15.', $e->getMessage());
            self::assertInstanceOf(ValidationFailed::class, $e);
        }
    }
}
