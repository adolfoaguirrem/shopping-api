<?php

namespace App\Domain\Cart;

use App\Domain\Cart\ValueObject\CartStatus;

class Cart
{
    private ?int $id = null;
    private $buyer_id;
    private $status;

    public function __construct(int $buyer_id, CartStatus $status)
    {
        $this->buyer_id = $buyer_id;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getbuyerId(): int
    {
        return $this->buyer_id;
    }

    public function getStatus(): CartStatus
    {
        return $this->status;
    }

    public function setStatus(CartStatus $status): self
    {
        $this->status = $status;
        return $this;
    }
}
