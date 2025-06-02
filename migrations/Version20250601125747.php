<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601125747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE akmaral_seyidova_about_me (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, skills CLOB NOT NULL, hobbies CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bzovii_elenadynamic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, descriere VARCHAR(255) NOT NULL, nume VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE dragan_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_account (account_id VARCHAR(15) NOT NULL, account_username VARCHAR(32) NOT NULL, account_password VARCHAR(75) NOT NULL, account_email VARCHAR(250) NOT NULL, PRIMARY KEY(account_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_article (article_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, article_title VARCHAR(250) NOT NULL, article_content CLOB DEFAULT NULL, article_date VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_BCABC8ECC3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BCABC8ECC3A7902E ON highlander_blog_article (highlander_blog_account)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_comment (comment_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, highlander_blog_article VARCHAR(255) NOT NULL, comment_content VARCHAR(1000) NOT NULL, CONSTRAINT FK_2AE594E6C3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2AE594E6BCABC8EC FOREIGN KEY (highlander_blog_article) REFERENCES highlander_blog_article (article_id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6C3A7902E ON highlander_blog_comment (highlander_blog_account)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6BCABC8EC ON highlander_blog_comment (highlander_blog_article)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_login (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(32) NOT NULL, password VARCHAR(32) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ionut_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rusu_catalin_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE akmaral_seyidova_about_me
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bzovii_elenadynamic
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE dragan_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_account
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_login
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ionut_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rusu_catalin_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
