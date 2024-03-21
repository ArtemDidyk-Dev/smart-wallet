<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource(operations: [new Get(), new GetCollection(), new Post(), new Patch(), new Delete()])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'money')]
    private Money $amount;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?Category $category = null;

    #[ApiProperty(readable: false, writable: false)]
    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAd;

    #[ApiProperty(readable: false, writable: false)]
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAd;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    private ?Finance $finance = null;

    public function __construct()
    {
        $this->createdAd = new \DateTimeImmutable();
        $this->updatedAd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAd(): ?\DateTimeImmutable
    {
        return $this->createdAd;
    }

    public function getUpdatedAd(): ?\DateTimeImmutable
    {
        return $this->updatedAd;
    }

    public function setUpdatedAd(\DateTimeImmutable $updatedAd): static
    {
        $this->updatedAd = $updatedAd;

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

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAd = new \DateTimeImmutable('now');
        $this->updatedAd = new \DateTimeImmutable('now');
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAd = new \DateTimeImmutable();
    }
}
