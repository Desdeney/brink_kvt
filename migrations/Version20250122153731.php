<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122153731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, housenr INTEGER DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, allows_birth_greet BOOLEAN NOT NULL, allows_reminder BOOLEAN NOT NULL, date_of_marriage DATE DEFAULT NULL, allows_congrats BOOLEAN NOT NULL, payment_id INTEGER NOT NULL, require_cash BOOLEAN NOT NULL, require_prepaid BOOLEAN NOT NULL, city VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO customer (id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid) SELECT id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, postal VARCHAR(255) NOT NULL COLLATE "BINARY", name VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, prename VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, street VARCHAR(255) DEFAULT NULL, housenr INTEGER DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, allows_birth_greet BOOLEAN NOT NULL, allows_reminder BOOLEAN NOT NULL, date_of_marriage DATE DEFAULT NULL, allows_congrats BOOLEAN NOT NULL, payment_id INTEGER NOT NULL, require_cash BOOLEAN NOT NULL, require_prepaid BOOLEAN NOT NULL, city_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO customer (id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid) SELECT id, prename, lastname, street, housenr, postal, email, phone, birthdate, allows_birth_greet, allows_reminder, date_of_marriage, allows_congrats, payment_id, require_cash, require_prepaid FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
    }
}
