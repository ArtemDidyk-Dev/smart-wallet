<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use InvalidArgumentException;
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
        $parentCategory = new Category();
        $parentCategory->setName('Father');
        $parentCategory->setSlug('father');
        $parentCategory->setAmount(new Money('10', new Currency('UAH')));

        $subCategory = new Category();
        $subCategory->setName('Baby');
        $subCategory->setSlug('kid');
        $subCategory->setAmount(new Money('10', new Currency('UAH')));
        $subCategory->setParent($parentCategory);

        $this->assertSame($parentCategory, $subCategory->getParent());
        $this->assertSame($subCategory, $parentCategory->getSubcategories()->first());
    }

    public function testExpectExceptionParentItSelf(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $category = new Category();
        $category->setName('Food');
        $category->setSlug('food');
        $category->setAmount(new Money('10', new Currency('UAH')));
        $category->setParent($category);
    }

    public function testExpectExceptionSubcategoryItSelf(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $category = new Category();
        $category->setName('Food');
        $category->setSlug('food');
        $category->setAmount(new Money('10', new Currency('UAH')));
        $category->addSubcategory($category);
    }

    public function testExpectExceptionParentIfAlreadyAChild(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $parentCategory = new Category();
        $parentCategory->setName('Father');
        $parentCategory->setSlug('father');
        $parentCategory->setAmount(new Money('10', new Currency('UAH')));

        $subCategory = new Category();
        $subCategory->setName('Baby');
        $subCategory->setSlug('kid');
        $subCategory->setAmount(new Money('10', new Currency('UAH')));
        $subCategory->setParent($parentCategory);

        $parentCategory->setParent($subCategory);


    }

    public function testExpectExceptionChildIfItIsAlreadyParent(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $parentCategory = new Category();
        $parentCategory->setName('Father');
        $parentCategory->setSlug('father');
        $parentCategory->setAmount(new Money('10', new Currency('UAH')));

        $subCategory = new Category();
        $subCategory->setParent($parentCategory);
        $subCategory->setName('Baby');
        $subCategory->setSlug('kid');
        $subCategory->setAmount(new Money('10', new Currency('UAH')));

        $subCategory->addSubcategory($parentCategory);
    }

}
