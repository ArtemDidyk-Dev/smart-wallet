<?php declare(strict_types=1);

namespace App\VO;

interface AbstractStringVOInterface
{
    public function __toString(): string;
    public static function createFromString(string $value): self;

    public function getValue(): string;

    public function equals(self $object): bool;

    public function isEmpty(): bool;

}