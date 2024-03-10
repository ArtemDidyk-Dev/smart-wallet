<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\Category as CategoryDTO;
use App\Entity\Category as CategoryEntity;
use App\VO\Category as CategoryVO;

class Mapper
{
    public static function createFromEntity(CategoryEntity $category): CategoryDTO
    {
        $slug = $category->getSlug() == null ? null : CategoryVO::createFromString($category->getSlug());
        $name = CategoryVO::createFromString($category->getName());

        return new CategoryDTO($name, $slug);
    }
}