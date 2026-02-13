<?php

namespace App\Entity;

use App\Repository\ChecklistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistRepository::class)]
class Checklist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'checklists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appointments $appointment = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $isPublic = false;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $publicToken = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publicPassword = null;

    #[ORM\Column]
    private ?bool $isCompleted = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\OneToMany(mappedBy: 'checklist', targetEntity: ChecklistQuestion::class, orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->publicToken = bin2hex(random_bytes(16));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointment(): ?Appointments
    {
        return $this->appointment;
    }

    public function setAppointment(?Appointments $appointment): static
    {
        $this->appointment = $appointment;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getPublicToken(): ?string
    {
        return $this->publicToken;
    }

    public function setPublicToken(?string $publicToken): static
    {
        $this->publicToken = $publicToken;

        return $this;
    }

    public function getPublicPassword(): ?string
    {
        return $this->publicPassword;
    }

    public function setPublicPassword(?string $publicPassword): static
    {
        $this->publicPassword = $publicPassword;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    /**
     * @return Collection<int, ChecklistQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(ChecklistQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setChecklist($this);
        }

        return $this;
    }

    public function removeQuestion(ChecklistQuestion $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getChecklist() === $this) {
                $question->setChecklist(null);
            }
        }

        return $this;
    }
}