<?php

namespace App\Entity\PetruLazar;

use App\Repository\PetruLazar\GlyphRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlyphRepository::class)]
class Glyph
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1)]
    private ?string $ancient_glyph = null;

    #[ORM\Column(length: 1)]
    private ?string $english_key = null;

    #[ORM\Column(length: 64)]
    private ?string $meaning = null;

    #[ORM\Column(length: 64)]
    private ?string $pronunciation = null;

    public function getArray(): array
    {
        return [
            "id" => $this->id,
            "ancient_glyph" => $this->ancient_glyph,
            "english_key" => $this->english_key,
            "meaning" => $this->meaning,
            "pronunciation" => $this->pronunciation
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAncientGlyph(): ?string
    {
        return $this->ancient_glyph;
    }

    public function setAncientGlyph(string $ancient_glyph): static
    {
        $this->ancient_glyph = $ancient_glyph;

        return $this;
    }

    public function getEnglishKey(): ?string
    {
        return $this->english_key;
    }

    public function setEnglishKey(string $english_key): static
    {
        $this->english_key = $english_key;

        return $this;
    }

    public function getMeaning(): ?string
    {
        return $this->meaning;
    }

    public function setMeaning(string $meaning): static
    {
        $this->meaning = $meaning;

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