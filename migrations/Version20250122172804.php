<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122172804 extends AbstractMigration
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
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, payment_id INTEGER NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, housenr INTEGER DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, require_cash BOOLEAN NOT NULL, require_prepaid BOOLEAN NOT NULL, city VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_81398E094C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer (id, prename, lastname, street, housenr, postal, email, phone, payment_id, require_cash, require_prepaid, city) SELECT id, prename, lastname, street, housenr, postal, email, phone, payment_id, require_cash, require_prepaid, city FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE INDEX IDX_81398E094C3A3BB ON customer (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, payment_id, prename, lastname, street, housenr, postal, city, email, phone, require_cash, require_prepaid FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, payment_id INTEGER NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, housenr INTEGER DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, require_cash BOOLEAN NOT NULL, require_prepaid BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO customer (id, payment_id, prename, lastname, street, housenr, postal, city, email, phone, require_cash, require_prepaid) SELECT id, payment_id, prename, lastname, street, housenr, postal, city, email, phone, require_cash, require_prepaid FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
    }
}
