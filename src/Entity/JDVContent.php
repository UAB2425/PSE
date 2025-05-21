<?php

namespace App\Entity;

use App\Repository\JDVContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JDVContentRepository::class)]
class JDVContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphOne = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphTwo = null;

    #[ORM\Column]
    private array $skills = [];

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParagraphOne(): ?string
    {
        return $this->paragraphOne;
    }

    public function setParagraphOne(string $paragraphOne): static
    {
        $this->paragraphOne = $paragraphOne;

        return $this;
    }

    public function getParagraphTwo(): ?string
    {
        return $this->paragraphTwo;
    }

    public function setParagraphTwo(string $paragraphTwo): static
    {
        $this->paragraphTwo = $paragraphTwo;

        return $this;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function setSkills(array $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
