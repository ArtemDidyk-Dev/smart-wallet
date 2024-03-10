<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $amount = null;


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

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subcategories')]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", nullable: true)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $subcategories;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Finance $finance = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getFinanceId(): ?Finance
    {
        return $this->finance;
    }

    public function setFinanceId(?Finance $finance): static
    {
        $this->finance = $finance;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(self $subcategory): self
    {
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


}
