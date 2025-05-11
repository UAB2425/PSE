<?php

namespace App\Entity\PetruLazar;

use App\Repository\PetruLazar\WordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $glyphs = null;

    #[ORM\Column(length: 64)]
    private ?string $translation = null;

    #[ORM\Column]
    private ?bool $confirmed = null;

    #[ORM\Column(length: 64)]
    private ?string $pronunciation = null;

    public function getArray(): array
    {
        return [
            "id" => $this->id,
            "glyphs" => $this->glyphs,
            "translation" => $this->translation,
            "confirmed" => $this->confirmed,
            "pronunciation" => $this->pronunciation
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGlyphs(): ?string
    {
        return $this->glyphs;
    }

    public function setGlyphs(string $glyphs): static
    {
        $this->glyphs = $glyphs;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): static
    {
        $this->translation = $translation;

        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): static
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getPronunciation(): ?string
    {
        return $this->pronunciation;
    }

    public function setPronunciation(string $pronunciation): static
    {
        $this->pronunciation = $pronunciation;

        return $this;
    }
}
