<?php
 
 declare(strict_types=1);
 
 namespace DoctrineMigrations;
 
 use Doctrine\DBAL\Schema\Schema;
 use Doctrine\Migrations\AbstractMigration;
 
 /**
  * Auto-generated Migration: Please modify to your needs!
  */
 final class Version20250319163258 extends AbstractMigration
 {
     public function getDescription(): string
     {
         return '';
     }
 
     public function up(Schema $schema): void
     {
         // this up() migration is auto-generated, please modify it to your needs
         $this->addSql('CREATE TABLE IF NOT EXISTS dragan_page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
         $this->addSql('DROP TABLE IF EXISTS page_content');
     }
 
     public function down(Schema $schema): void
     {
         // this down() migration is auto-generated, please modify it to your needs
         $this->addSql('CREATE TABLE IF NOT EXISTS page_content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE "BINARY", content CLOB NOT NULL COLLATE "BINARY")');
         $this->addSql('DROP TABLE IF EXISTS dragan_page_content');
     }
 }