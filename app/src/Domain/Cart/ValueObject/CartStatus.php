<?php

namespace App\Domain\Cart\ValueObject;

use InvalidArgumentException;

class CartStatus
{
    public const OPEN = 'open';
    public const PENDING = 'pending';
    public const CANCELED = 'cancelled';
    public const COMPLETE = 'complete';

    private $status;

    public function __construct(string $status)
    {
        $this->validate($status);
        $this->status = $status;
    }

    public function value(): string
    {
        return $this->status;
    }

    public function __toString()
    {
        return $this->status;
    }

    private function validate($status)
    {
        if (empty($status) || !in_array($status, [self::OPEN, self::PENDING, self::CANCELED, self::COMPLETE])) {
            throw new InvalidArgumentException('Invalid status value');
        }
    }
}
