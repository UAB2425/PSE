<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class PetrutiuContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titlu;

    #[ORM\Column(type: 'text')]
    private $descriere;

    #[ORM\Column(type: 'string', length: 255)]
    private $hobbyuri;

    #[ORM\Column(type: 'string', length: 255)]
    private $educatie;

    #[ORM\Column(type: 'string', length: 255)]
    private $experienta;

    // Getters și Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlu(): ?string
    {
        return $this->titlu;
    }

    public function setTitlu(string $titlu): self
    {
        $this->titlu = $titlu;
        return $this;
    }

    public function getDescriere(): ?string
    {
        return $this->descriere;
    }

    public function setDescriere(string $descriere): self
    {
        $this->descriere = $descriere;
        return $this;
    }

    public function getHobbyuri(): ?string
    {
        return $this->hobbyuri;
    }

    public function setHobbyuri(string $hobbyuri): self
    {
        $this->hobbyuri = $hobbyuri;
        return $this;
    }

    public function getEducatie(): ?string
    {
        return $this->educatie;
    }

    public function setEducatie(string $educatie): self
    {
        $this->educatie = $educatie;
        return $this;
    }

    public function getExperienta(): ?string
    {
        return $this->experienta;
    }

    public function setExperienta(string $experienta): self
    {
        $this->experienta = $experienta;
        return $this;
    }
}
