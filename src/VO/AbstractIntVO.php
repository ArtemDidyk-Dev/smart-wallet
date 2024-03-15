<?php

declare(strict_types=1);

namespace App\VO;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractIntVO implements AbstractIntVOInterface
{
    protected int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function equals(self|AbstractIntVOInterface $value): bool
    {
        return $this->value === $value->value;
    }

    public static function fromInt(int $value): static
    {
        /* @phpstan-ignore-next-line */
        return new static($value);
    }
}