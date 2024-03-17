<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testNameAndSlugForCategory(): void
    {
        $category = new Category();
        $category->setName('Increase the price');
        $category->setSlug('increase-the-price');
        $this->assertSame('Increase the price', $category->getName());
        $this->assertSame('increase-the-price', $category->getSlug());

    }

    public function testAmountForCategory(): void
    {
        $category = new Category();
        $category->setAmount(new Money('10', new Currency('UAH')));
        $amount = $category->getAmount();
        $this->assertInstanceOf(Money::class, $amount);
        $this->assertSame('10', $amount->getAmount());
        $this->assertInstanceOf(Currency::class, $amount->getCurrency());
        $this->assertSame('UAH', $amount->getCurrency()->getCode());
    }

    public function testSubcategory(): void
    {
        $category = new Category();
        $category->setName('Increase the price');
        $category->setSlug('increase-the-price');
        $category->setAmount(new Money('10', new Currency('UAH')));

        $categorySub =  new Category();
        $categorySub->setName('Restaurant');
        $categorySub->setSlug('restaurant');
        $categorySub->setAmount(new Money('10', new Currency('UAH')));
        $categorySub->setParent($category);
        $this->assertInstanceOf( Category::class, $categorySub->getParent());

    }

}
