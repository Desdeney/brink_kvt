<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $location_name = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(nullable: true)]
    private ?int $streetnr = null;

    #[ORM\Column]
    private ?int $postal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, LocationImages>
     */
    #[ORM\OneToMany(targetEntity: LocationImages::class, mappedBy: 'location_id')]
    private Collection $locationImages;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    private ?Contacts $contact_id = null;

    public function __construct()
    {
        $this->locationImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationName(): ?string
    {
        return $this->location_name;
    }

    public function setLocationName(string $location_name): static
    {
        $this->location_name = $location_name;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetnr(): ?int
    {
        return $this->streetnr;
    }

    public function setStreetnr(?int $streetnr): static
    {
        $this->streetnr = $streetnr;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(int $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

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
     * @return Collection<int, LocationImages>
     */
    public function getLocationImages(): Collection
    {
        return $this->locationImages;
    }

    public function addLocationImage(LocationImages $locationImage): static
    {
        if (!$this->locationImages->contains($locationImage)) {
            $this->locationImages->add($locationImage);
            $locationImage->setLocationId($this);
        }

        return $this;
    }

    public function removeLocationImage(LocationImages $locationImage): static
    {
        if ($this->locationImages->removeElement($locationImage)) {
            // set the owning side to null (unless already changed)
            if ($locationImage->getLocationId() === $this) {
                $locationImage->setLocationId(null);
            }
        }

        return $this;
    }

    public function getContactId(): ?Contacts
    {
        return $this->contact_id;
    }

    public function setContactId(?Contacts $contact_id): static
    {
        $this->contact_id = $contact_id;

        return $this;
    }
}
