<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602073300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE akmaral_seyidova_about_me ADD COLUMN github VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE akmaral_seyidova_about_me ADD COLUMN linkedin VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE akmaral_seyidova_about_me ADD COLUMN kaggle VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highlander_blog_article AS SELECT highlander_blog_account, article_id, article_title, article_content, article_date FROM highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_article (article_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, article_title VARCHAR(250) NOT NULL, article_content CLOB DEFAULT NULL, article_date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(article_id), CONSTRAINT FK_BCABC8ECC3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highlander_blog_article (highlander_blog_account, article_id, article_title, article_content, article_date) SELECT highlander_blog_account, article_id, article_title, article_content, article_date FROM __temp__highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BCABC8ECC3A7902E ON highlander_blog_article (highlander_blog_account)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highlander_blog_comment AS SELECT highlander_blog_account, highlander_blog_article, comment_id, comment_content FROM highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_comment (comment_id VARCHAR(255) NOT NULL, highlander_blog_account VARCHAR(15) NOT NULL, highlander_blog_article VARCHAR(255) NOT NULL, comment_content VARCHAR(1000) NOT NULL, PRIMARY KEY(comment_id), CONSTRAINT FK_2AE594E6C3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2AE594E6BCABC8EC FOREIGN KEY (highlander_blog_article) REFERENCES highlander_blog_article (article_id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highlander_blog_comment (highlander_blog_account, highlander_blog_article, comment_id, comment_content) SELECT highlander_blog_account, highlander_blog_article, comment_id, comment_content FROM __temp__highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6BCABC8EC ON highlander_blog_comment (highlander_blog_article)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6C3A7902E ON highlander_blog_comment (highlander_blog_account)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__akmaral_seyidova_about_me AS SELECT id, name, title, description, skills, hobbies FROM akmaral_seyidova_about_me
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE akmaral_seyidova_about_me
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE akmaral_seyidova_about_me (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, skills CLOB NOT NULL, hobbies CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO akmaral_seyidova_about_me (id, name, title, description, skills, hobbies) SELECT id, name, title, description, skills, hobbies FROM __temp__akmaral_seyidova_about_me
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__akmaral_seyidova_about_me
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highlander_blog_article AS SELECT article_id, highlander_blog_account, article_title, article_content, article_date FROM highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_article (highlander_blog_account VARCHAR(15) NOT NULL, article_id VARCHAR(255) NOT NULL, article_title VARCHAR(250) NOT NULL, article_content CLOB DEFAULT NULL, article_date VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_BCABC8ECC3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highlander_blog_article (article_id, highlander_blog_account, article_title, article_content, article_date) SELECT article_id, highlander_blog_account, article_title, article_content, article_date FROM __temp__highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highlander_blog_article
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BCABC8ECC3A7902E ON highlander_blog_article (highlander_blog_account)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__highlander_blog_comment AS SELECT comment_id, highlander_blog_account, highlander_blog_article, comment_content FROM highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE highlander_blog_comment (highlander_blog_account VARCHAR(15) NOT NULL, highlander_blog_article VARCHAR(255) NOT NULL, comment_id VARCHAR(255) NOT NULL, comment_content VARCHAR(1000) NOT NULL, CONSTRAINT FK_2AE594E6C3A7902E FOREIGN KEY (highlander_blog_account) REFERENCES highlander_blog_account (account_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2AE594E6BCABC8EC FOREIGN KEY (highlander_blog_article) REFERENCES highlander_blog_article (article_id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO highlander_blog_comment (comment_id, highlander_blog_account, highlander_blog_article, comment_content) SELECT comment_id, highlander_blog_account, highlander_blog_article, comment_content FROM __temp__highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__highlander_blog_comment
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6C3A7902E ON highlander_blog_comment (highlander_blog_account)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2AE594E6BCABC8EC ON highlander_blog_comment (highlander_blog_article)
        SQL);
    }
}
