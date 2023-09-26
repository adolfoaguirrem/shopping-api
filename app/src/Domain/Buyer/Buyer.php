<?php

namespace App\Domain\Buyer;

use App\Domain\Buyer\ValueObject\BuyerName;

/**
 * @property BuyerName $name representing Buyer name
 * @package App\Domain\Entity\Buyer
 */
class Buyer
{
    private ?int $id = null;

    public function __construct(private BuyerName $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): BuyerName
    {
        return $this->name;
    }

    public function setName(BuyerName $name): self
    {
        $this->name = $name;
        return $this;
    }
}
