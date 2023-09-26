<?php

namespace App\Infrastructure\Doctrine\Orm\Types;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Domain\Product\ValueObject\ProductPrice;

class ProductPriceType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?float
    {
        if ($value instanceof ProductPrice) {
            return $value->value();
        }

        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ProductPrice($value);
    }

    public function getName()
    {
        return 'product_price';
    }

    public function getPrecision()
    {
        return 8;
    }

    public function getScale()
    {
        return 2;
    }
}
