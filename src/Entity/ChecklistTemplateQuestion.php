<?php

namespace App\Entity;

use App\Repository\ChecklistTemplateQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistTemplateQuestionRepository::class)]
class ChecklistTemplateQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChecklistTemplate $template = null;

    #[ORM\Column(length: 255)]
    private ?string $questionText = null;

    #[ORM\Column(length: 50)]
    private ?string $fieldType = 'text'; // text, textarea, select, checkbox, radio

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $fieldOptions = null;

    #[ORM\Column]
    private ?bool $isRequired = false;

    #[ORM\Column]
    private ?int $position = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplate(): ?ChecklistTemplate
    {
        return $this->template;
    }

    public function setTemplate(?ChecklistTemplate $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): static
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getFieldType(): ?string
    {
        return $this->fieldType;
    }

    public function setFieldType(string $fieldType): static
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    public function getFieldOptions(): ?array
    {
        return $this->fieldOptions;
    }

    public function setFieldOptions(?array $fieldOptions): static
    {
        $this->fieldOptions = $fieldOptions;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): static
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}