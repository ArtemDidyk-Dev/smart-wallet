<?php

namespace App\Builder;

use App\VO\Category;
use App\Entity\Category as CategoryEntity;

class BuilderCategory implements BuilderCategoryInterface
{
    protected CategoryEntity $category;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->category = new CategoryEntity();
    }

    public function setName(string $name): self
    {
        $this->category->setName($name);
        return $this;
    }

    public function get(): CategoryEntity
    {
        $category = $this->category;
        $this->reset();
        return  $category;
    }
}