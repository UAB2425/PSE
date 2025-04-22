<?php

namespace App\Entity;

use App\Repository\HighlanderBlogAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HighlanderBlogAccountRepository::class)]
class HighlanderBlogAccount
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 15)]
    private ?string $account_id = null;

    #[ORM\Column(length: 32)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 32)]
    private ?string $account_username = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 32)]
    private ?string $account_password = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $account_email = null;

    public function __construct()
    {
        $this->account_id = '0';
    }   

    public function getAccountId(): ?string
    {
        return $this->account_id;
    }

    public function getAccountUsername(): ?string
    {
        return $this->account_username;
    }

    public function setAccountUsername(string $username): static
    {
        $this->account_username = $username;

        return $this;
    }

    public function getAccountPassword(): ?string
    {
        return $this->account_password;
    }

    public function setAccountPassword(string $password): static
    {
        $this->account_password = $password;

        return $this;
    }

    public function getAccountEmail(): ?string
    {
        return $this->account_email;
    }

    public function setAccountEmail(string $email): static
    {
        $this->account_email = $email;

        return $this;
    }
}
