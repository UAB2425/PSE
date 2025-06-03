<?php

namespace App\Entity;

use App\Repository\PopaDianaPageContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopaDianaPageContentRepository::class)]
#[ORM\Table(name: "popadiana_pagecontent")]
class PopaDianaPageContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titlu = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Continut = null;

    #[ORM\Column(length: 255)]
    private ?string $sectiune = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlu(): ?string
    {
        return $this->Titlu;
    }

    public function setTitlu(string $Titlu): static
    {
        $this->Titlu = $Titlu;

        return $this;
    }

    public function getContinut(): ?string
    {
        return $this->Continut;
    }

    public function setContinut(string $Continut): static
    {
        $this->Continut = $Continut;

        return $this;
    }

    public function getSectiune(): ?string
    {
        return $this->sectiune;
    }

    public function setSectiune(string $sectiune): static
    {
        $this->sectiune = $sectiune;
        return $this;
    }
}
