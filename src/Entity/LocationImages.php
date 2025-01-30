<?php

namespace App\Entity;

use App\Repository\LocationImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationImagesRepository::class)]
class LocationImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image_name = null;

    #[ORM\ManyToOne(inversedBy: 'locationImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): static
    {
        $this->image_name = $image_name;

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
}
