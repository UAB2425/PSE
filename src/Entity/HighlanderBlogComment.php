<?php

namespace App\Entity;

use App\Repository\HighlanderBlogCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HighlanderBlogCommentRepository::class)]
class HighlanderBlogComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $comment_id = null;

    #[ORM\Column(length: 1000)]
    private ?string $comment_content = null;

    #[ORM\ManyToOne(targetEntity: HighlanderBlogAccount::class)]
    #[ORM\JoinColumn(nullable: false, name: "highlander_blog_account", referencedColumnName: "account_id")]
    private ?HighlanderBlogAccount $highlander_blog_account = null;

    #[ORM\ManyToOne(targetEntity: HighlanderBlogArticle::class, inversedBy: 'article_comments')]
    #[ORM\JoinColumn(nullable: false, name: "highlander_blog_article", referencedColumnName: "article_id")]
    private ?HighlanderBlogArticle $highlander_blog_article = null; 

    public function getCommentId(): ?string
    {
        return $this->comment_id;
    }

    public function getCommentContent(): ?string
    {
        return $this->comment_content;
    }

    public function setCommentContent(string $comment_content): static
    {
        $this->comment_content = $comment_content;

        return $this;
    }

    public function getHighlanderBlogAccount(): ?HighlanderBlogAccount
    {
        return $this->highlander_blog_account;
    }

    public function setHighlanderBlogAccount(?HighlanderBlogAccount $account): static
    {
        $this->highlander_blog_account = $account;

        return $this;
    }

    public function getHighlanderBlogArticle(): ?HighlanderBlogArticle
    {
        return $this->highlander_blog_article;
    }

    public function setHighlanderBlogArticle(?HighlanderBlogArticle $article): static
    {
        $this->highlander_blog_article = $article;

        return $this;
    }
}
