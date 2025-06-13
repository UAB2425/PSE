<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613192140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(64) NOT NULL, password VARCHAR(128) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bzovii_elenadynamic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, descriere VARCHAR(255) NOT NULL, nume VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE dragan_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE glyph (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ancient_glyph VARCHAR(1) NOT NULL, english_key VARCHAR(1) NOT NULL, meaning VARCHAR(64) NOT NULL, pronunciation VARCHAR(64) NOT NULL)
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
            CREATE TABLE jdv_comp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(200) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE jdv_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE petrutiu_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titlu VARCHAR(255) NOT NULL, descriere CLOB NOT NULL, hobbyuri VARCHAR(255) NOT NULL, educatie VARCHAR(255) NOT NULL, experienta VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE phrase (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE phrase_element (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, phrase_id INTEGER NOT NULL, word_id INTEGER NOT NULL, position_in_phrase INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE popadiana_pagecontent (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titlu VARCHAR(255) NOT NULL, continut CLOB NOT NULL, sectiune VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rusu_catalin_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE word (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, glyphs VARCHAR(64) NOT NULL, translation VARCHAR(64) NOT NULL, confirmed BOOLEAN NOT NULL, pronunciation VARCHAR(64) NOT NULL)
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
            DROP TABLE account
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bzovii_elenadynamic
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE dragan_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE glyph
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
            DROP TABLE jdv_comp
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jdv_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE petrutiu_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE phrase
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE phrase_element
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE popadiana_pagecontent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rusu_catalin_page_content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE word
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
