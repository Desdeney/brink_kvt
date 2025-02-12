<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130194837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contacts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id_id INTEGER DEFAULT NULL, location_name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, streetnr INTEGER DEFAULT NULL, postal INTEGER NOT NULL, city VARCHAR(255) NOT NULL, notes CLOB DEFAULT NULL, CONSTRAINT FK_5E9E89CB526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contacts (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB526E8E58 ON location (contact_id_id)');
        $this->addSql('CREATE TABLE location_images (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id_id INTEGER NOT NULL, image_name VARCHAR(255) NOT NULL, CONSTRAINT FK_AB6D3668918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AB6D3668918DB72 ON location_images (location_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_images');
    }
}
