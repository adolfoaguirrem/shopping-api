<?php

namespace App\Domain\Product\ValueObject;

use InvalidArgumentException;

final class ProductName
{

    public function __construct(private string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    public function validate($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('The name cannot be an empty string.');
        }
    }
}
