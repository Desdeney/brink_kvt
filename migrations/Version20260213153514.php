<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213153514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_questionnaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, appointment_id INTEGER NOT NULL, genres CLOB DEFAULT NULL --(DC2Type:json)
        , must_haves CLOB DEFAULT NULL, no_gos CLOB DEFAULT NULL, atmosphere CLOB DEFAULT NULL, is_submitted BOOLEAN DEFAULT NULL, CONSTRAINT FK_52277BB1E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52277BB1E5B533F9 ON music_questionnaire (appointment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE music_questionnaire');
    }
}
