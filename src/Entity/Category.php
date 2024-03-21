<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\CategoryNameEnum;
use App\Repository\CategoryRepository;
use App\Trait\CategoryEquals;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use Webmozart\Assert\Assert;
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(operations: [new Get(), new GetCollection(), new Post(), new Patch(), new Delete()])]
class Category
{
    use CategoryEquals;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug;

    #[ORM\Column(type: 'money')]
    private Money $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAmount(): ?Money
    {
        return $this->amount;
    }

    public function setAmount(Money $amount): static
    {
        assert($amount instanceof Money);
        $this->amount = $amount;

        return $this;
    }

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subcategories')]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", nullable: true)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $subcategories;


    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Transaction::class)]
    private Collection $transactions;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?Finance $finance = null;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->name = CategoryNameEnum::DEFAULT_CATEGORY_NAME;
        $this->slug = CategoryNameEnum::DEFAULT_CATEGORY_SLAG;
        $this->amount = new Money(0, new Currency('UAH'));
    }


    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): self
    {
        $this->parent = $parent;

        if (!$this->getSubcategories()->isEmpty()) {
            $this->getSubcategories()->map(function ($category) {
                if ($this->equalsToObject($category, $this->parent)) {
                    throw new InvalidArgumentException('An object cannot be a parent if it is already a child');
                }
            });
        }

        if ($this->equals($this->parent)) {
            throw new InvalidArgumentException('Object can not be parent of itself');
        }

        $this->parent->getSubcategories()->add($this);
        return $this;
    }

    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(self $subcategory): self
    {
        if ($this->equals($subcategory)) {
            throw new InvalidArgumentException('Category can not be subcategory of itself');
        }

        if ($this->equalsToObject($this->getParent(), $subcategory)) {
            throw new InvalidArgumentException('Category cannot be a child if it is already a parent');
        }


        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setParent($this);
        }

        return $this;
    }

    public function removeSubcategory(self $subcategory): self
    {
        if ($this->subcategories->removeElement($subcategory)) {
            if ($subcategory->getParent() === $this) {
                $subcategory->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setCategory($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCategory() === $this) {
                $transaction->setCategory(null);
            }
        }

        return $this;
    }

    public function getFinance(): ?Finance
    {
        return $this->finance;
    }

    public function setFinance(?Finance $finance): static
    {
        $this->finance = $finance;

        return $this;
    }

}
