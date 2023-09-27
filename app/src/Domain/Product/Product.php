<?php

namespace App\Domain\Product;

use App\Domain\Product\ValueObject\ProductName;
use App\Domain\Product\ValueObject\ProductPrice;

class Product
{
    private ?int $id = null;

    public function __construct(private ProductName $name, private ProductPrice $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function setName(ProductName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ProductPrice
    {
        return $this->price;
    }

    public function setPrice(ProductPrice $price): self
    {
        $this->price = $price;
        return $this;
    }
}
