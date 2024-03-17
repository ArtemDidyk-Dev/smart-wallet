<?php

namespace App\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Money\Currency;
use Money\Money;

class MoneyType extends Type
{

    public function getName(): string
    {
        return 'money';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Money
    {
        if ($value === null) {
            return null;
        }

        $data = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        return new Money($data['amount'], new Currency($data['currency']));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value instanceof Money) {
            return null;
        }

        $data = ['amount' => $value->getAmount(), 'currency' => $value->getCurrency()->getCode()];
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }
}