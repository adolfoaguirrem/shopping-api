<?php

namespace App\Infrastructure\Doctrine\Orm\Types;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Domain\Product\ValueObject\ProductName;

class ProductNameType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof ProductName) {
            return $value->value();
        }

        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ProductName
    {
        return new ProductName($value);
    }

    public function getName()
    {
        return 'product_name';
    }

    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 255;
    }
}
