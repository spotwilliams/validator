# Custom PHP Validator

This is a custom PHP validator that allows you to validate input data with ease, following a Laravel-inspired approach. The validator class provided allows you to validate data against a set of rules defined in an array format. Refer to this [Medium](https://medium.com/@ricardovergarawork/php-writing-my-own-input-validator-just-for-fun-39ffbea1a342) post to see what's about.

## Getting Started

1. Clone this repository to your local environment.
2. Include the `Validator.php` file in your PHP project.
3. Create an instance of the `Validator` class.
4. Define your validation rules as an associative array.
5. Call the `validate` method with your data and rules.

```php
$validator = new Validator();
$rules = [
    'field_1' => ['required', 'min:3'],
    'field_2' => ['email'],
    // Add more rules as needed.
];

$data = [
    'field_1' => 'example',
    'field_2' => 'example@example.com',
    // Add more data fields as needed.
];

try {
    $validator->validate($data, $rules);
    // Validation passed.
} catch (ValidationException $e) {
    // Validation failed. Handle errors.
}
```

## Adding Custom Rules

To add custom validation rules, you can extend the `ValidationRule` interface and add your rule implementation.

```php
class CustomValidationRule implements ValidationRule
{
    public function apply(string $ruleName, string $field, mixed $value = null, $constraint = null): bool
    {
        // Your custom validation logic here.
    }
}
```

## Contributing

Feel free to contribute to this project by adding new validation rules, improving the code, or fixing any issues. Please create a pull request, and we'll be happy to review it.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

This README provides a basic overview of how to use the custom PHP validator. Please refer to the repository for more detailed information and examples.