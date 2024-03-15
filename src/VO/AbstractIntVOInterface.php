<?php declare(strict_types=1);
namespace App\VO;

interface AbstractIntVOInterface
{

    public function __toString();
    public function toInt();
    public function equals(self $value): bool;
    public static function fromInt(int $value);

}