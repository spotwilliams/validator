<?php

use Spotwilliams\Validator\Rules;

/**
 *  Register list of available validation rules outside of the `Validator` class
 */
return [
    'rules' => [
        'in' => Rules\In::class,
        'nullable' => Rules\Nullable::class,
        'required' => Rules\Required::class,
        'between' => Rules\Between::class,
    ]
];
