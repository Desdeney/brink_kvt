<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Objects $object_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Appointments $appointment_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Location $location_id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer_id = null;

    #[ORM\Column]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getObjectId(): ?Objects
    {
        return $this->object_id;
    }

    public function setObjectId(?Objects $object_id): static
    {
        $this->object_id = $object_id;

        return $this;
    }

    public function getAppointmentId(): ?Appointments
    {
        return $this->appointment_id;
    }

    public function setAppointmentId(?Appointments $appointment_id): static
    {
        $this->appointment_id = $appointment_id;

        return $this;
    }

    public function getLocationId(): ?Location
    {
        return $this->location_id;
    }

    public function setLocationId(?Location $location_id): static
    {
        $this->location_id = $location_id;

        return $this;
    }

    public function getCustomerId(): ?Customer
    {
        return $this->customer_id;
    }

    public function setCustomerId(?Customer $customer_id): static
    {
        $this->customer_id = $customer_id;

        return $this;
    }
}