<?php

namespace App\Entity;

use App\Repository\HighlanderBlogArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HighlanderBlogArticleRepository::class)]
class HighlanderBlogArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $article_id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 250)]
    private ?string $article_title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 8000, nullable: true)]
    private ?string $article_content = null;

    #[ORM\Column(nullable: true)]
    private ?string $article_date = null;

    #[ORM\ManyToOne(targetEntity: HighlanderBlogAccount::class)]
    #[ORM\JoinColumn(nullable: false, name: "highlander_blog_account", referencedColumnName: "account_id")]
    private ?HighlanderBlogAccount $highlanderBlogAccount = null;

    #[ORM\OneToMany(mappedBy: 'highlander_blog_article', targetEntity: HighlanderBlogComment::class, cascade: ['persist'])]
    private Collection $article_comments;

    public function __construct(){
        $this->article_comments = new ArrayCollection();
    }

    public function getArticleId(): ?int
    {
        return $this->article_id;
    }

    public function getArticleTitle(): ?string
    {
        return $this->article_title;
    }

    public function setArticleTitle(string $article_title): static
    {
        $this->article_title = $article_title;

        return $this;
    }

    public function getArticleContent(): ?string
    {
        return $this->article_content;
    }

    public function setArticleContent(?string $article_content): static
    {
        $this->article_content = $article_content;

        return $this;
    }

    public function getHighlanderBlogAccount(): ?HighlanderBlogAccount
    {
        return $this->highlanderBlogAccount;
    }

    public function setHighlanderBlogAccount(?HighlanderBlogAccount $owner): static
    {
        $this->highlanderBlogAccount = $owner;

        return $this;
    }

    public function getArticleDate(): ?string
    {
        return $this->article_date;
    }

    public function setArticleDate(?string $date): static
    {
        $this->article_date = $date;

        return $this;
    }

    public function getArticleComments(): Collection
    {
        return $this->article_comments;
    }

    public function addArticleComment(HighlanderBlogComment $comment): self
    {
        if (!$this->article_comments->contains($comment)) {
            $this->article_comments[] = $comment;
            $comment->setHighlanderBlogArticle($this);
        }

        return $this;
    }

    public function removeArticleComment(HighlanderBlogComment $comment): self
    {
        if ($this->article_comments->removeElement($comment)) {
            if ($comment->getHighlanderBlogArticle() === $this) {
                $comment->setHighlanderBlogArticle(null);
            }
        }

        return $this;
    }
}
