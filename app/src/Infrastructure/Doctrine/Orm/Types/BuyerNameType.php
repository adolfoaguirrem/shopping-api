<?php

namespace App\Infrastructure\Doctrine\Orm\Types;

use Doctrine\DBAL\Types\StringType;
use App\Domain\Buyer\ValueObject\BuyerName;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class BuyerNameType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof BuyerName) {
            return $value->value();
        }

        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): BuyerName
    {
        return new BuyerName($value);
    }

    public function getName()
    {
        return 'buyer_name';
    }

    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 255;
    }
}
