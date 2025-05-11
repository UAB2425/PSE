<?php

namespace App\Entity\PetruLazar;

use App\Repository\PetruLazar\PhraseElementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhraseElementRepository::class)]
class PhraseElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $phrase_id = null;

    #[ORM\Column]
    private ?int $word_id = null;

    #[ORM\Column]
    private ?int $position_in_phrase = null;

    public function getArray(): array
    {
        return [
            "id" => $this->id,
            "phrase_id" => $this->phrase_id,
            "word_id" => $this->word_id,
            "position_in_phrase" => $this->position_in_phrase,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhraseId(): ?int
    {
        return $this->phrase_id;
    }

    public function setPhraseId(int $phrase_id): static
    {
        $this->phrase_id = $phrase_id;

        return $this;
    }

    public function getWordId(): ?int
    {
        return $this->word_id;
    }

    public function setWordId(int $word_id): static
    {
        $this->word_id = $word_id;

        return $this;
    }

    public function getPositionInPhrase(): ?int
    {
        return $this->position_in_phrase;
    }

    public function setPositionInPhrase(int $position_in_phrase): static
    {
        $this->position_in_phrase = $position_in_phrase;

        return $this;
    }
}
