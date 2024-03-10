<?php declare(strict_types=1);
namespace App\VO;
abstract class AbstractStringVO implements AbstractStringVOInterface
{
    protected string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function createFromString(string $value): self
    {
        return new static($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(self|AbstractStringVOInterface $object): bool
    {
        return $this->getValue() === $object->getValue();
    }

    public function isEmpty(): bool
    {
        return '' === $this->value;
    }
}