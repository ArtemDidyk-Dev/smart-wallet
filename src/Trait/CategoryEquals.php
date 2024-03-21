<?php declare(strict_types=1);

namespace App\Trait;

trait CategoryEquals
{
    public function equals(?self $other): bool
    {
        if (is_null($other) || is_null($this)) {
            return false;
        }
        return $this->getName() === $other->getName() && $this->getSlug() === $other->getSlug();
    }

    public function equalsToObject(self $object, self $objectSecond): bool
    {
        return $object->getName() === $objectSecond->getName() && $object->getSlug() === $objectSecond->getSlug();
    }
}