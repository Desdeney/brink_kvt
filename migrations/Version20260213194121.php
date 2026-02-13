<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213194121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checklist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, appointment_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, is_public BOOLEAN NOT NULL, public_token VARCHAR(255) DEFAULT NULL, is_completed BOOLEAN NOT NULL, completed_at DATETIME DEFAULT NULL, CONSTRAINT FK_5C696D2FE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C696D2FAE981E3B ON checklist (public_token)');
        $this->addSql('CREATE INDEX IDX_5C696D2FE5B533F9 ON checklist (appointment_id)');
        $this->addSql('CREATE TABLE checklist_question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, checklist_id INTEGER NOT NULL, question_text VARCHAR(255) NOT NULL, field_type VARCHAR(50) NOT NULL, field_options CLOB DEFAULT NULL --(DC2Type:json)
        , is_required BOOLEAN NOT NULL, position INTEGER NOT NULL, answer CLOB DEFAULT NULL, CONSTRAINT FK_EBF3358CB16D08A7 FOREIGN KEY (checklist_id) REFERENCES checklist (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EBF3358CB16D08A7 ON checklist_question (checklist_id)');
        $this->addSql('CREATE TABLE checklist_template (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE checklist_template_question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, template_id INTEGER NOT NULL, question_text VARCHAR(255) NOT NULL, field_type VARCHAR(50) NOT NULL, field_options CLOB DEFAULT NULL --(DC2Type:json)
        , is_required BOOLEAN NOT NULL, position INTEGER NOT NULL, CONSTRAINT FK_C030E9165DA0FB8 FOREIGN KEY (template_id) REFERENCES checklist_template (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C030E9165DA0FB8 ON checklist_template_question (template_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE checklist');
        $this->addSql('DROP TABLE checklist_question');
        $this->addSql('DROP TABLE checklist_template');
        $this->addSql('DROP TABLE checklist_template_question');
    }
}
