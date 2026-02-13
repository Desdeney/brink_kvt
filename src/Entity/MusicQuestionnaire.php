<?php

namespace App\Entity;

use App\Repository\MusicQuestionnaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicQuestionnaireRepository::class)]
class MusicQuestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appointments $appointment = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $genres = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mustHaves = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noGos = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $atmosphere = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSubmitted = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointment(): ?Appointments
    {
        return $this->appointment;
    }

    public function setAppointment(Appointments $appointment): static
    {
        $this->appointment = $appointment;

        return $this;
    }

    public function getGenres(): ?array
    {
        return $this->genres;
    }

    public function setGenres(?array $genres): static
    {
        $this->genres = $genres;

        return $this;
    }

    public function getMustHaves(): ?string
    {
        return $this->mustHaves;
    }

    public function setMustHaves(?string $mustHaves): static
    {
        $this->mustHaves = $mustHaves;

        return $this;
    }

    public function getNoGos(): ?string
    {
        return $this->noGos;
    }

    public function setNoGos(?string $noGos): static
    {
        $this->noGos = $noGos;

        return $this;
    }

    public function getAtmosphere(): ?string
    {
        return $this->atmosphere;
    }

    public function setAtmosphere(?string $atmosphere): static
    {
        $this->atmosphere = $atmosphere;

        return $this;
    }

    public function isSubmitted(): ?bool
    {
        return $this->isSubmitted;
    }

    public function setIsSubmitted(?bool $isSubmitted): static
    {
        $this->isSubmitted = $isSubmitted;

        return $this;
    }
}