<?php

namespace App\Infrastructure\Exception;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    protected array $validationMessages = [];

    public function __construct(array $validationMessages)
    {
        $this->validationMessages = $validationMessages;
    }

    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }
}