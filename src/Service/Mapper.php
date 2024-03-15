<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\Category as CategoryDTO;
use App\Entity\Category;
use App\Entity\Category as CategoryEntity;
use App\VO\Category as CategoryVO;
use Doctrine\ORM\EntityManagerInterface;
use Money\Currency;
use Money\Money;

class Mapper
{
    public static function createFromEntity(CategoryEntity $category): CategoryDTO
    {
        return new CategoryDTO(
            name: $category->getSlug() == null ? null : CategoryVO::createFromString($category->getSlug()),
            slug: CategoryVO::createFromString($category->getName()),
            amount: $category->getAmount()->getAmount() ?? null,
            currencyCode: $category->getAmount()->getCurrency()->getCode()
        );
    }
}
