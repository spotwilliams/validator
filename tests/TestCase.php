<?php

declare(strict_types=1);

namespace Tests;

use Spotwilliams\Validator\Validator;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new Validator();
    }
}
