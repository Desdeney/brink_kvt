<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212203101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id_id INTEGER NOT NULL, location_id_id INTEGER DEFAULT NULL, occasion VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME DEFAULT NULL, is_confirmed INTEGER DEFAULT NULL, setup_with_location INTEGER DEFAULT NULL, teardown_with_location INTEGER DEFAULT NULL, setup_date DATE DEFAULT NULL, setup_time TIME DEFAULT NULL, teardown_date DATE DEFAULT NULL, teardown_time TIME DEFAULT NULL, attendees_count INTEGER DEFAULT NULL, attendees_age_from INTEGER DEFAULT NULL, attendees_age_to INTEGER DEFAULT NULL, attendees_notes CLOB DEFAULT NULL, music_pdf_path VARCHAR(255) DEFAULT NULL, dj_notes CLOB DEFAULT NULL, price_dj_hour DOUBLE PRECISION NOT NULL, price_dj_extention DOUBLE PRECISION NOT NULL, price_tech DOUBLE PRECISION NOT NULL, price_approach DOUBLE PRECISION NOT NULL, CONSTRAINT FK_6A41727AB171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6A41727A918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6A41727AB171EB6C ON appointments (customer_id_id)');
        $this->addSql('CREATE INDEX IDX_6A41727A918DB72 ON appointments (location_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointments');
    }
}
