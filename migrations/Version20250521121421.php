<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521121421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bzovii_elenadynamic (id INT AUTO_INCREMENT NOT NULL, descriere VARCHAR(255) NOT NULL, nume VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dragan_page_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlander_blog_account (account_id VARCHAR(15) NOT NULL, account_username VARCHAR(32) NOT NULL, account_password VARCHAR(75) NOT NULL, account_email VARCHAR(250) NOT NULL, PRIMARY KEY(account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlander_blog_article (article_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, article_title VARCHAR(250) NOT NULL, article_content VARCHAR(8000) DEFAULT NULL, article_date VARCHAR(255) DEFAULT NULL, INDEX IDX_BCABC8ECC3A7902E (highlander_blog_account), PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlander_blog_comment (comment_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, highlander_blog_article VARCHAR(255) NOT NULL, comment_content VARCHAR(1000) NOT NULL, INDEX IDX_2AE594E6C3A7902E (highlander_blog_account), INDEX IDX_2AE594E6BCABC8EC (highlander_blog_article), PRIMARY KEY(comment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlander_blog_login (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(32) NOT NULL, password VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ionut_page_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rusu_catalin_page_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE highlander_blog_article ADD CONSTRAINT FK_BCABC8ECC3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id)');
        $this->addSql('ALTER TABLE highlander_blog_comment ADD CONSTRAINT FK_2AE594E6C3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id)');
        $this->addSql('ALTER TABLE highlander_blog_comment ADD CONSTRAINT FK_2AE594E6BCABC8EC FOREIGN KEY (highlander_blog_article) REFERENCES highlander_blog_article (article_id)');
        $this->addSql('ALTER TABLE jdvcontent CHANGE updated_at updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE highlander_blog_article DROP FOREIGN KEY FK_BCABC8ECC3A7902E');
        $this->addSql('ALTER TABLE highlander_blog_comment DROP FOREIGN KEY FK_2AE594E6C3A7902E');
        $this->addSql('ALTER TABLE highlander_blog_comment DROP FOREIGN KEY FK_2AE594E6BCABC8EC');
        $this->addSql('DROP TABLE bzovii_elenadynamic');
        $this->addSql('DROP TABLE dragan_page_content');
        $this->addSql('DROP TABLE highlander_blog_account');
        $this->addSql('DROP TABLE highlander_blog_article');
        $this->addSql('DROP TABLE highlander_blog_comment');
        $this->addSql('DROP TABLE highlander_blog_login');
        $this->addSql('DROP TABLE ionut_page_content');
        $this->addSql('DROP TABLE rusu_catalin_page_content');
        $this->addSql('ALTER TABLE jdvcontent CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
