<?php

use Spotwilliams\Validator\Rules;

return [
    'rules' => [
        'in' => Rules\In::class,
        'nullable' => Rules\Nullable::class,
        'required' => Rules\Required::class,
    ]
];
