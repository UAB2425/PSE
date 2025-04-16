<?php

namespace App\Entity;

use App\Repository\BzoviiElenadynamicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BzoviiElenadynamicRepository::class)]
class BzoviiElenadynamic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Descriere = null;

    #[ORM\Column(length: 255)]
    private ?string $Nume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriere(): ?string
    {
        return $this->Descriere;
    }

    public function setDescriere(string $Descriere): static
    {
        $this->Descriere = $Descriere;

        return $this;
    }

    public function getNume(): ?string
    {
        return $this->Nume;
    }

    public function setNume(string $Nume): static
    {
        $this->Nume = $Nume;

        return $this;
    }
}
