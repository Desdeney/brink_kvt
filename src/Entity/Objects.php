<?php

namespace App\Entity;

use App\Repository\ObjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: ObjectsRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class Objects
{
    use SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modell = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $serial = null;

    #[ORM\Column]
    private ?int $available_amount = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'object_id')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModell(): ?string
    {
        return $this->modell;
    }

    public function setModell(?string $modell): static
    {
        $this->modell = $modell;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): static
    {
        $this->serial = $serial;

        return $this;
    }

    public function getAvailableAmount(): ?int
    {
        return $this->available_amount;
    }

    public function setAvailableAmount(int $available_amount): static
    {
        $this->available_amount = $available_amount;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setObjectId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getObjectId() === $this) {
                $order->setObjectId(null);
            }
        }

        return $this;
    }
}