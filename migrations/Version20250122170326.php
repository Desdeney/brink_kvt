<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122170326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, prename, lastname, street, housenr, postal, email, phone, payment_id, require_cash, require_prepaid, city FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, housenr INTEGER DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, payment_id INTEGER NOT NULL, require_cash BOOLEAN NOT NULL, require_prepaid BOOLEAN NOT NULL, city VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO customer (id, prename, lastname, street, housenr, postal, email, phone, payment_id, require_cash, require_prepaid, city) SELECT id, prename, lastname, street, housenr, postal, email, phone, payment_id, require_cash, require_prepaid, city FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD COLUMN birthdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD COLUMN allows_birth_greet BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE customer ADD COLUMN allows_reminder BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE customer ADD COLUMN date_of_marriage DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD COLUMN allows_congrats BOOLEAN NOT NULL');
    }
}
