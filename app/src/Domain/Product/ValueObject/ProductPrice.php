<?php

namespace App\Domain\Product\ValueObject;

use InvalidArgumentException;

final class ProductPrice
{
    private $price;

    public function __construct($price)
    {
        $this->validate($price);
        $this->price = (float) $price;
    }

    public function value(): float
    {
        return $this->price;
    }

    public function validate($price)
    {
        if (is_null($price)) {
            throw new InvalidArgumentException('The price cannot be null.');
        }

        if ($price < 0) {
            throw new InvalidArgumentException('The price cannot be less than 0.');
        }
    }
}
