<?php

namespace App\DTO;

use \App\VO\Category as CategoryNameVO;

final readonly class Category
{
    public function __construct(public CategoryNameVO $name, public CategoryNameVO $slug)
    {

    }
}