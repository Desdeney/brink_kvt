<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213211800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checklist ADD COLUMN public_password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__checklist AS SELECT id, appointment_id, title, is_public, public_token, is_completed, completed_at FROM checklist');
        $this->addSql('DROP TABLE checklist');
        $this->addSql('CREATE TABLE checklist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, appointment_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, is_public BOOLEAN NOT NULL, public_token VARCHAR(255) DEFAULT NULL, is_completed BOOLEAN NOT NULL, completed_at DATETIME DEFAULT NULL, CONSTRAINT FK_5C696D2FE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO checklist (id, appointment_id, title, is_public, public_token, is_completed, completed_at) SELECT id, appointment_id, title, is_public, public_token, is_completed, completed_at FROM __temp__checklist');
        $this->addSql('DROP TABLE __temp__checklist');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C696D2FAE981E3B ON checklist (public_token)');
        $this->addSql('CREATE INDEX IDX_5C696D2FE5B533F9 ON checklist (appointment_id)');
    }
}
