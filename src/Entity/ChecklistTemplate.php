<?php

namespace App\Entity;

use App\Repository\ChecklistTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistTemplateRepository::class)]
class ChecklistTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'template', targetEntity: ChecklistTemplateQuestion::class, orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ChecklistTemplateQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(ChecklistTemplateQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setTemplate($this);
        }

        return $this;
    }

    public function removeQuestion(ChecklistTemplateQuestion $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getTemplate() === $this) {
                $question->setTemplate(null);
            }
        }

        return $this;
    }
}